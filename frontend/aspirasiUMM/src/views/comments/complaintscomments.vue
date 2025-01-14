<script>
import api from "../../api";

export default {
  data() {
    return {
      comments: [],
      complaint: null,
      newComment: "",
      currentUser: null,
      isLoading: true,
      error: null,
      userId: null,
      editingComment: null,
      editedContent: "",
      userRole: null,
    };
  },
  methods: {
    async fetchComplaint() {
  try {
    const token = localStorage.getItem("token");
    if (!token) throw new Error("Token not found");

    const response = await api.get(`/api/complaint/${this.$route.params.id}`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    if (response.data.success) {
      this.complaint = response.data.data;

      console.log("Complaint data:", this.complaint);
    } else {
      throw new Error(response.data.message || "Failed to fetch complaint");
    }
  } catch (error) {
    console.error("Error fetching complaint:", error);
    this.error = "Failed to load complaint details";
    this.isLoading = false;
  }
},
    async fetchComments() {
      try {
        const token = localStorage.getItem("token");
        if (!token) throw new Error("Token not found");

        const response = await api.get(
          `/api/complaint/${this.$route.params.id}/comments`,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.data.success) {
          this.comments = response.data.data.sort(
            (a, b) => new Date(a.created_at) - new Date(b.created_at)
          );
        } else {
          throw new Error(response.data.message || "Failed to fetch comments");
        }
      } catch (error) {
        console.error("Error fetching comments:", error);
        this.error = "Failed to load comments";
      } finally {
        this.isLoading = false;
      }
    },
    async getCurrentUser() {
      try {
        const token = localStorage.getItem("token");
        if (!token) throw new Error("Token not found");

        const response = await api.get("/api/user", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.data) {
          this.currentUser = response.data;
          this.userId = response.data.nim || response.data.id;
          this.userRole = response.data.role;
        } else {
          throw new Error("Failed to fetch user data");
        }
      } catch (error) {
        console.error("Error fetching user data:", error);
        this.error = "Failed to load user data";
      }
    },
    startEditing(comment) {
      this.editingComment = comment.id;
      this.editedContent = comment.isi_komentar;
    },
    cancelEditing() {
      this.editingComment = null;
      this.editedContent = "";
    },
    async updateComment(commentId) {
      try {
        const token = localStorage.getItem("token");
        if (!token) throw new Error("Token not found");

        const response = await api.put(
          `/api/comment/${commentId}`,
          {
            isi_komentar: this.editedContent,
          },
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.data.success) {
          await this.fetchComments();
          this.cancelEditing();
        } else {
          throw new Error(response.data.message || "Failed to update comment");
        }
      } catch (error) {
        console.error("Error updating comment:", error);
        this.error = "Failed to update comment. Please try again.";
      }
    },
    async deleteComment(commentId) {
      if (!confirm("Apakah Anda yakin ingin menghapus komentar ini?")) return;

      try {
        const token = localStorage.getItem("token");
        if (!token) throw new Error("Token not found");

        const response = await api.delete(`/api/comment/${commentId}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.data.success) {
          await this.fetchComments();
        } else {
          throw new Error(response.data.message || "Failed to delete comment");
        }
      } catch (error) {
        console.error("Error deleting comment:", error);
        this.error = "Failed to delete comment. Please try again.";
      }
    },
    async postComment() {
      if (!this.newComment.trim()) return;

      try {
        const token = localStorage.getItem("token");
        if (!token) throw new Error("Token not found");

        const response = await api.post(
          `/api/complaint/${this.$route.params.id}/comment`,
          {
            pengaduan_id: this.$route.params.id,
            user_id: this.userId,
            isi_komentar: this.newComment,
            is_admin: this.userRole === 'admin' ? 1 : 0,
          },
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        if (response.data.success) {
          this.newComment = "";
          await this.fetchComments();
        } else {
          throw new Error(response.data.message || "Failed to post comment");
        }
      } catch (error) {
        console.error("Error posting comment:", error);
        this.error = "Failed to send comment. Please try again.";
      }
    },
    formatDate(dateString) {
      try {
        return new Date(dateString).toLocaleDateString("id-ID", {
          year: "numeric",
          month: "long",
          day: "numeric",
          hour: "2-digit",
          minute: "2-digit",
        });
      } catch (error) {
        console.error("Error formatting date:", error);
        return dateString;
      }
    },
    getUserAvatar(user) {
      if (!user) return this.getDefaultImage();
      if (user.image) return user.image;
      return `https://ui-avatars.com/api/?name=${encodeURIComponent(
        user.name || "User"
      )}&background=random`;
    },
    getDefaultImage() {
      return "https://ui-avatars.com/api/?background=random";
    },
    handleImageError(event) {
      event.target.src = this.getDefaultImage();
    },

    async fetchDataUser() {
      const response = await api.get("/api/get-user");
      this.users = response.data.data.data || [];
    },
  },
  async mounted() {
    try {
      await this.getCurrentUser();
      await this.fetchComplaint();
      await this.fetchComments();
      this.fetchDataUser();
    } catch (err) {
      console.error("Error during initial data load:", err);
      this.error = "Failed to load initial data";
    }
  },
};
</script>

<template>
  <section class="bg-light">
    <div class="container py-5">
      <div class="row d-flex justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
          <!-- Error Alert -->
          <div v-if="error" class="alert alert-danger mb-4" role="alert">
            {{ error }}
          </div>

          <!-- Complaint Details -->
          <div class="card mb-4" v-if="complaint">
            <div class="card-body">
              <div class="d-flex flex-start align-items-center mb-3">
              
                <div>
                
                  <p class="text-muted small mb-0">
                    {{ complaint.kategori }} -
                    {{ formatDate(complaint.created_at) }}
                  </p>
                </div>
              </div>
              <p class="card-text" style="color: black">
                {{ complaint.deskripsi }}
              </p>
            </div>
          </div>

          <!-- Comments Section -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4">Komentar</h5>

           
              <div v-if="isLoading" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>

              <!-- Comments List -->
              <div v-else>
                <div
                  v-if="comments.length === 0"
                  class="text-center text-muted py-4"
                >
                  <p>Belum ada komentar.</p>
                </div>

                <div
                  v-else
                  v-for="comment in comments"
                  :key="comment.id"
                  class="comment-item mb-4"
                >
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        class="rounded-circle shadow-1-strong me-3"
                        :src="getUserAvatar(comment.user)"
                        :alt="comment.user?.name || 'User Avatar'"
                        width="40"
                        height="40"
                        @error="handleImageError"
                      />
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <div
                        class="d-flex justify-content-between align-items-center"
                      >
                        <h6 class="mb-0 d-flex align-items-center">
                          {{ comment.user?.name || "User" }}
                          <span
                            v-if="comment.is_admin"
                            class="admin-badge ms-2"
                          >
                            Admin
                          </span>
                        </h6>
                        <div class="d-flex align-items-center">
                          <small class="text-muted me-3">{{
                            formatDate(comment.created_at)
                          }}</small>
                  
                          <div
                            v-if="comment.user_id === userId"
                            class="btn-group"
                          >
                            <button
                              v-if="editingComment !== comment.id"
                              @click="startEditing(comment)"
                              class="btn btn-sm btn-outline-primary me-2"
                            >
                              Edit
                            </button>
                            <button
                              @click="deleteComment(comment.id)"
                              class="btn btn-sm btn-outline-danger"
                            >
                              Hapus
                            </button>
                          </div>
                        </div>
                      </div>
                     
                      <div v-if="editingComment === comment.id" class="mt-2">
                        <textarea
                          v-model="editedContent"
                          class="form-control mb-2"
                          rows="3"
                        ></textarea>
                        <div class="text-end">
                          <button
                            @click="cancelEditing"
                            class="btn btn-sm btn-outline-secondary me-2"
                          >
                            Batal
                          </button>
                          <button
                            @click="updateComment(comment.id)"
                            class="btn btn-sm btn-primary"
                          >
                            Simpan
                          </button>
                        </div>
                      </div>
                  
                      <p v-else class="mt-2 mb-0" style="color: black">
                        {{ comment.isi_komentar }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- New Comment Form -->
              <div class="mt-4">
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <img
                      class="rounded-circle shadow-1-strong me-3"
                      :src="getUserAvatar(currentUser)"
                      :alt="currentUser?.name || 'Your Avatar'"
                      width="40"
                      height="40"
                      @error="handleImageError"
                    />
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <textarea
                      v-model="newComment"
                      class="form-control"
                      rows="3"
                      placeholder="Tulis komentar Anda..."
                    ></textarea>
                    <div class="mt-2 text-end">
                      <button
                        @click="postComment"
                        class="btn btn-primary"
                        :disabled="!newComment.trim() || isLoading"
                      >
                        {{ isLoading ? "Mengirim..." : "Kirim Komentar" }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.card {
  border-radius: 15px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.comment-item {
  border-bottom: 1px solid #eee;
  padding-bottom: 1rem;
}

.comment-item:last-child {
  border-bottom: none;
}

.form-control {
  border-radius: 10px;
  border: 1px solid #ddd;
}

.form-control:focus {
  border-color: #143672;
  box-shadow: 0 0 0 0.2rem rgba(20, 54, 114, 0.25);
}

.btn-primary {
  background-color: #143672;
  border-color: #143672;
}

.btn-primary:hover {
  background-color: #0a2a48;
  border-color: #0a2a48;
}

.btn-primary:disabled {
  background-color: #6c757d;
  border-color: #6c757d;
  cursor: not-allowed;
}

.btn-outline-primary {
  color: #143672;
  border-color: #143672;
}

.btn-outline-primary:hover {
  background-color: #143672;
  color: white;
}

.btn-outline-danger {
  color: #dc3545;
  border-color: #dc3545;
}

.btn-outline-danger:hover {
  background-color: #dc3545;
  color: white;
}

.shadow-1-strong {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.admin-badge {
  background-color: #143672;
  color: white;
  font-size: 0.75rem;
  padding: 2px 8px;
  border-radius: 12px;
  font-weight: 500;
  display: inline-block;
}


</style>