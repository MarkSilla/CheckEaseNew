<template>
  <div class="container d-flex justify-content-center align-items-center vh-100" style="margin-left: 150px;">
    <!-- Form Section -->
<<<<<<< HEAD
    <div class="card p-4 m-5 mt-3" style="width: 850px; height: auto; border-radius: 20px; background-color: #fdf6f5;">
      <form @submit.prevent="createClass" class="d-flex flex-column">
        <!-- Class Name Input -->
        <div class="form-group mb-4">
          <label for="className" class="form-label font-weight-bold">Subject</label>
          <input v-model="className" type="text" class="form-control custom-input" id="className" placeholder="Enter Class Name" required>
        </div>

        <!-- Class Section Input -->
        <div class="form-group mb-4">
          <label for="classSection" class="form-label font-weight-bold">Class Section</label>
          <input v-model="classSection" type="text" class="form-control custom-input" id="classSection" placeholder="Enter Class Section" required>
        </div>

        <!-- Student Capacity Input -->
=======
    <div class="card p-4 m-5 mt-3" style="width: 830px; height: 260px; border-radius: 20px; background-color: #fdf6f5;">
      <form @submit.prevent="createClass" class="d-flex flex-column justify-content-between">
        <div class="form-group mb-3">
          <label for="className" class="form-label font-weight-bold">Class Name</label>
          <input v-model="className" type="text" class="form-control custom-input" id="className" placeholder="Enter Class Name" required>
        </div>
        
>>>>>>> origin/main
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
<<<<<<< HEAD
          <div v-if="capacityError" class="text-danger mt-1" style="font-size: 12px;">
            {{ capacityError }}
          </div>
        </div>

=======
          <div v-if="capacityError" style="color: red; font-size: 12px;">
            {{ capacityError }}
          </div>
        </div>
        
>>>>>>> origin/main
        <!-- Create Button -->
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn custom-btn"><b>Create</b></button>
        </div>
      </form>
    </div>

    <!-- Display Created Classes Below the Form -->
<<<<<<< HEAD
    <div class="card p-4 mt-4" style="width: 850px; border-radius: 20px; background-color: #fdf6f5;">
=======
    <div class="card p-4 mt-4" style="width: 830px; border-radius: 20px; background-color: #fdf6f5;">
>>>>>>> origin/main
      <h5 class="font-weight-bold mb-3">Created Classes</h5>
      <div class="list-group">
        <div v-if="classes.length === 0" class="list-group-item">
          <p>No classes created yet.</p>
        </div>
        <div v-else>
<<<<<<< HEAD
          <div v-for="(classItem, index) in classes" :key="index" class="list-group-item d-flex justify-content-between align-items-start mb-3" style="border-radius: 10px;">
            <!-- Display Class Information in Separate Lines -->
            <div>
              <strong class="class-name">{{ classItem.class_name }}</strong><br>
              <small><strong>Student Capacity: </strong>{{ classItem.capacity }}</small><br>
              <small><strong>Class Section: </strong>{{ classItem.section }}</small><br>
              <small><strong>Class Code: </strong>{{ classItem.class_code || 'N/A'}}</small>
=======
          <div v-for="(classItem, index) in classes" :key="index" class="list-group-item d-flex justify-content-between align-items-center mb-2" style="border-radius: 10px;">
            <div>
              <strong>{{ classItem.class_name }}</strong><br>
              <small><strong>Student Capacity: </strong>{{ classItem.capacity }}</small><br>
              <small><strong>Class Code: </strong>{{classItem.class_code }}</small>
>>>>>>> origin/main
            </div>
            <div>
              <button @click="editClass(classItem)" class="btn btn-primary btn-sm mx-2"><b>Edit</b></button>
              <button @click="deleteClass(classItem)" class="btn btn-danger btn-sm"><b>Delete</b></button>
<<<<<<< HEAD
=======

>>>>>>> origin/main
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
<<<<<<< HEAD
  baseURL: 'http://localhost/CheckEaseNEW-main/vue-login-backend',
=======
  baseURL: 'http://localhost/CheckEaseExp-NEW/vue-login-backend',
>>>>>>> origin/main
  headers: {
    'Content-Type': 'application/json',
  },
});

export default {
  data() {
    return {
      className: '',
<<<<<<< HEAD
      classSection: '',  
      class_code: '', 
=======
>>>>>>> origin/main
      capacity: '',
      classes: [],
      capacityError: '',
      token: localStorage.getItem('token') || '',
      isLoading: false,
    };
  },
  methods: {
    showNotification(type, message) {
      ElNotification({
        type,
        message,
        duration: 3000,
      });
    },

<<<<<<< HEAD
    async fetchClasses() {
=======
    loadClassesFromLocalStorage() {
      const storedClasses = localStorage.getItem('classes');
      if (storedClasses) {
        this.classes = JSON.parse(storedClasses);
        console.log('Loaded classes from localStorage:', this.classes);
      }
    },

    removeClassFromLocalStorage(classCode) {
      const storedClasses = JSON.parse(localStorage.getItem('classes')) || [];
      const updatedClasses = storedClasses.filter(classItem => classItem.class_code !== classCode);
      localStorage.setItem('classes', JSON.stringify(updatedClasses));
    },

    async fetchClasses() {
      this.loadClassesFromLocalStorage();

>>>>>>> origin/main
      if (!this.token) {
        this.showNotification('error', 'You must be logged in to view classes');
        return;
      }

      try {
        const response = await api.get('/fetchClasses.php', {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });

<<<<<<< HEAD
        if (response.data.success) { 
          this.classes = response.data.classes;
          localStorage.setItem('classes', JSON.stringify(this.classes));  
=======
        if (response.data.success) {
          this.classes = response.data.classes;
          localStorage.setItem('classes', JSON.stringify(this.classes));
>>>>>>> origin/main
          console.log('Classes fetched from server:', this.classes);
        } else {
          this.showNotification('error', response.data.error || 'Failed to fetch classes');
          if (response.data.error === 'Invalid or expired token') {
            this.logout();
          }
        }
      } catch (error) {
        console.error('Error fetching classes:', error);
        this.showNotification('error', 'An error occurred while fetching classes');
      }
    },

    async createClass() {
<<<<<<< HEAD
  this.capacityError = '';

  if (!this.className || !this.capacity || !this.classSection) {
    this.capacityError = 'Class name, class section, and capacity are required';
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
        section: this.classSection,  
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
        section: this.classSection,  
        capacity: this.capacity,
        class_code: response.data.class_code, 
      };

      this.classes.unshift(newClass); 
      localStorage.setItem('classes', JSON.stringify(this.classes));  
      this.showNotification('success', 'Class created successfully!');

      this.className = '';
      this.classSection = '';  
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
=======
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
>>>>>>> origin/main

    async deleteClass(classItem) {
      console.log('Deleting class:', classItem);
      if (!this.token) {
        this.showNotification('error', 'You must be logged in to delete classes');
        return;
      }

      const classCode = classItem.class_code || classItem.id;

      try {
        const response = await api.delete(`/delete.php?class_code=${classCode}`, {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });

        if (response.data.success) {
<<<<<<< HEAD
=======
          this.removeClassFromLocalStorage(classCode);
>>>>>>> origin/main
          this.classes = this.classes.filter((classItem) => classItem.class_code !== classCode);
          localStorage.setItem('classes', JSON.stringify(this.classes));
          this.showNotification('success', 'Class deleted successfully');
        } else {
          this.showNotification('error', response.data.error || 'Failed to delete class');
        }
      } catch (error) {
        console.error('Error deleting class:', error);
        this.showNotification('error', 'An error occurred while deleting the class');
      }
    },

<<<<<<< HEAD
    editClass(classItem) {
      console.log('Editing class:', classItem);
    },

    logout() {
      localStorage.removeItem('token');
      this.token = '';
      this.showNotification('info', 'You have been logged out');
    },
  },

  mounted() {
=======
    logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('role');
      localStorage.removeItem('classes');
      this.showNotification('info', 'Your session has expired. Please log in again.');
      this.$router.push({ name: 'Login' });
    },
  },
  mounted() {
    this.loadClassesFromLocalStorage();
>>>>>>> origin/main
    this.fetchClasses();
  },
};
</script>



<style scoped>
<<<<<<< HEAD
.class-name {
  font-size: 1.5rem; 
  font-weight: bold;
}
=======
>>>>>>> origin/main
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
<<<<<<< HEAD
  padding: 10px;
}

.custom-btn {
  background-color: #66a3c7; 
=======
}

.custom-btn {
  background-color:  #66a3c7; 
>>>>>>> origin/main
  color: white;
  border-radius: 10px; 
  padding: 8px 16px;
  border: none;
<<<<<<< HEAD
  font-weight: bold;
  text-transform: uppercase;
}

.custom-btn:hover {
  background-color: #5a8fa3; 
=======
}

.custom-btn:hover {
  background-color: #66a3c7; 
>>>>>>> origin/main
}

.list-group-item {
  background-color: #fdf6f5;
  border: none;
}

.list-group-item:hover {
  background-color: #f2e6e2;
}
<<<<<<< HEAD

.text-danger {
  color: red;
}
=======
>>>>>>> origin/main
</style>
