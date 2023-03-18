<template>
  <div class="container">
      <form @submit.prevent="addPost" class="post-form">
        <div class="form-group">
          <label for="nom" class="form-label">Nom:</label>
          <input type="text" id="nom" v-model="nom" class="form-input">
        </div>
        <div class="form-group">
          <label for="description" class="form-label">Description:</label>
          <textarea id="description" v-model="description" class="form-input"></textarea>
        </div>
        <div class="form-group">
          <label for="image" class="form-label">Image:</label>
          <input type="file" id="image" @change="onFileChange" class="form-input">
        </div>
        <button type="submit" class="form-btn">Add Post</button>
      </form>
  </div>
</template>


<script>
import { ref,onMounted } from 'vue';
import axios from 'axios';
import { createToaster } from "@meforma/vue-toaster";
import { useRouter } from "vue-router";


export default {
  setup() {
    const router = useRouter();
    const toaster = createToaster({ position:"top" });
    
    const nom = ref('');
    const description = ref('');
    const image = ref(null);
    const token =ref('')
    const id_user =ref()

    onMounted(() => {
        getTokenFromLocalStorage()
    });

    const getTokenFromLocalStorage = ()=>{
      if (localStorage.getItem('access_token')) {
        token.value = localStorage.getItem('access_token')
        id_user.value = localStorage.getItem('id')
      }
    }

    const addPost = async () => {
      // const formData = new FormData();
      // formData.append('title', nom.value);
      // formData.append('content', description.value);
      // formData.append('image', image.value);
      
      const formData = {
        nom: nom.value,
        description: description.value,
        image: image.value,
        user_id:id_user.value
      }
      console.log(formData);
      await axios.post('http://127.0.0.1:8000/api/NewPost', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Authorization':`Bearer ${token.value}`
        }
      })
      .then(res=>{
        if (res.data) {
            router.push({ path: '/' })
            toaster.success(`Added Succesfully`);
        }
      })
      .catch(err=>console.log(err.message))

      // Reset the form fields
      nom.value = '';
      description.value = '';
      image.value = null;
    };

    const onFileChange = (event) => {
      image.value = event.target.files[0];
      console.log(image.value );
    };

    return {
      nom,
      description,
      token,
      id_user,
      image,
      addPost,
      onFileChange
    };
  }
};
</script>
  
  <style>
  .container{
    width: 100%;
    height: 80vh;
    display: flex;
    align-items: center;
  }
  .post-form {
    max-width: 500px;
    margin: 0 auto;
  }
  
  .form-group {
    margin-bottom: 1rem;
  }
  
  .form-label {
    display: block;
    margin-bottom: 0.5rem;
  }
  
  .form-input {
    display: block;
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  
  .form-btn {
    display: inline-block;
    background-color: #4CAF50;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s;
  }
  
  .form-btn:hover {
    background-color: #3e8e41;
  }
  </style>
  