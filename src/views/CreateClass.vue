<template>
  <div class="container d-flex justify-content-center align-items-center vh-100" style="margin-left: 150px;">
    <!-- Form Section -->
    <div class="card p-4 m-5 mt-3" style="width: 830px; height: 260px; border-radius: 20px; background-color: #fdf6f5;">
      <form @submit.prevent="createClass" class="d-flex flex-column justify-content-between">
        <div class="form-group mb-3">
          <label for="className" class="form-label font-weight-bold">Class Name</label>
          <input v-model="className" type="text" class="form-control custom-input" id="className" placeholder="Enter Class Name" required>
        </div>
        
        <div class="form-group mb-4">
          <label for="capacity" class="form-label font-weight-bold">Student Capacity</label>
          <input 
            v-model="capacity" 
            type="number" 
            class="form-control custom-input" 
            id="capacity" 
            placeholder="Enter Capacity" 
            required
          />
          <!-- Display Capacity Error below the input (only once) -->
          <div v-if="capacityError" style="color: red; font-size: 12px;">
            {{ capacityError }}
          </div>
        </div>
        
        <!-- Create Button -->
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn custom-btn"><b>Create</b></button>
        </div>
      </form>
    </div>

    <!-- Display Created Classes Below the Form -->
    <div class="card p-4 mt-4" style="width: 830px; border-radius: 20px; background-color: #fdf6f5;">
      <h5 class="font-weight-bold mb-3">Created Classes</h5>
      <div class="list-group">
        <div v-if="classes.length === 0" class="list-group-item">
          <p>No classes created yet.</p>
        </div>
        <div v-else>
          <div v-for="(classItem, index) in classes" :key="index" class="list-group-item d-flex justify-content-between align-items-center mb-2" style="border-radius: 10px;">
            <div>
              <strong>{{ classItem.class_name }}</strong><br>
              <small><strong>Student Capacity: </strong>{{ classItem.capacity }}</small><br>
              <small><strong>Class Code: </strong>{{classItem.class_code }}</small>
            </div>
            <div>
              <button class="btn btn-info btn-sm">View</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import { ElNotification } from 'element-plus';

const api = axios.create({
  baseURL: 'http://localhost/CheckEaseExp-NEW/vue-login-backend',
  headers: {
    'Content-Type': 'application/json',
  },
});

export default {
  data() {
    return {
      className: '',
      capacity: '',
      classes: [], // List of classes
      capacityError: '',
      token: localStorage.getItem('token') || '', // Token from localStorage
      isLoading: false,
    };
  },
  methods: {
    /**
     * Show notifications using Element Plus
     */
    showNotification(type, message) {
      ElNotification({
        type,
        message,
        duration: 3000, // Notification duration in milliseconds
      });
    },

    /**
     * Load classes from localStorage
     */
    loadClassesFromLocalStorage() {
      const storedClasses = localStorage.getItem('classes');
      if (storedClasses) {
        this.classes = JSON.parse(storedClasses);
        console.log('Loaded classes from localStorage:', this.classes);
      }
    },

    /**
     * Fetch classes from the backend
     */
    async fetchClasses() {
      this.loadClassesFromLocalStorage(); // Load cached classes first

      if (!this.token) {
        this.showNotification('error', 'You must be logged in to view classes');
        return;
      }

      try {
        const response = await api.get('/fetchClasses.php', {
          headers: {
            Authorization: `Bearer ${this.token}`, // Send the token for authorization
          },
        });

        if (response.data.success) {
          this.classes = response.data.classes;  // After fetching from the backend
          localStorage.setItem('classes', JSON.stringify(this.classes));  // Store in localStorage  
          console.log('Classes fetched from server:', this.classes);
        } else {
          this.showNotification('error', response.data.error || 'Failed to fetch classes');
          // Optional: Logout user if token is invalid/expired
          if (response.data.error === 'Invalid or expired token') {
            this.logout();
          }
        }
      } catch (error) {
        console.error('Error fetching classes:', error);
        this.showNotification('error', 'An error occurred while fetching classes');
      }
    },

    /**
     * Create a new class
     */
    async createClass() {
      this.capacityError = '';

      if (!this.className || !this.capacity) {
        this.capacityError = 'Class name and capacity are required';
        return;
      }

      if (this.capacity <= 0 || isNaN(this.capacity)) {
        this.capacityError = 'Capacity must be a positive number';
        return;
      }

      if (!this.token) {
        this.showNotification('error', 'You must be logged in to create a class');
        return;
      }

      try {
        this.isLoading = true;
        const response = await api.post(
          '/createclass.php',
          {
            class_name: this.className,
            capacity: this.capacity,
          },
          {
            headers: {
              Authorization: `Bearer ${this.token}`, 
            },
          }
        );

        if (response.data.success) {
          const newClass = {
            class_name: this.className,
            capacity: this.capacity,
            class_code: response.data.class_code,
          };

          this.classes.push(newClass); 
          localStorage.setItem('classes', JSON.stringify(this.classes)); 
          console.log('Class created and saved to localStorage:', newClass);

          this.showNotification('success', 'Class created successfully!');
          this.className = '';
          this.capacity = ''; 
        } else {
          this.showNotification('error', response.data.error || 'Failed to create class');
        }
      } catch (error) {
        console.error('Error creating class:', error);
        this.showNotification('error', 'An error occurred while creating the class');
      } finally {
        this.isLoading = false;
      }
    },

    /**
     * Logout the user by clearing the token and class data
     */
    logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('classes');
      this.token = '';
      this.classes = [];
      this.showNotification('info', 'You have been logged out due to an invalid or expired token.');
      console.log('Logged out successfully.');
    },
  },
  created() {
    this.loadClassesFromLocalStorage();
    this.fetchClasses(); // Load classes when component is created
  },
};
</script>



<style scoped>

.card {
  border-radius: 20px; 
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); 
  background-color: #fdf6f5; 
}

.font-weight-bold {
  font-weight: bold;
}

.custom-input {
  border-radius: 10px;
  box-shadow: inset 0px 2px 4px rgba(0, 0, 0, 0.1); 
}

.custom-btn {
  background-color:  #66a3c7; 
  color: white;
  border-radius: 10px; 
  padding: 8px 16px;
  border: none;
}

.custom-btn:hover {
  background-color: #66a3c7; 
}

.list-group-item {
  background-color: #fdf6f5;
  border: none;
}

.list-group-item:hover {
  background-color: #f2e6e2;
}
</style>
