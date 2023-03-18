<template>
    <div class="posts-page">
      <div class="header">
        <h1>Posts</h1>
      </div>
      <div class="posts-container">
        <div v-for="(post, index) in posts" :key="index" class="post">
          <div class="post-image">
            <img :src="'http://127.0.0.1:8000/storage/images/' + post.image" alt="Post image">
          </div>
          <div>
            <p class="maker">{{ post.user.name }}</p>
          </div>
          <div class="post-content">
            <h2>{{ post.nom }}</h2>
            <p>{{ post.description }}</p>
            <div>
              <Comments :id="post.id"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { ref,onMounted } from 'vue';
  import Comments from './Comments.vue';

  export default {
    name: 'PostsPage',
    components: {
      Comments
    },
    setup() {
        onMounted(() => {
            GetAllPosts()
        });
        let posts = ref([]);
        

        const GetAllPosts = async()=>{
            await axios('http://127.0.0.1:8000/api/getPosts')
            .then(res=>{
              console.log(res.data)
              posts.value = res.data
            })
            .catch(err=>console.log(err.message))
        }
  
      return {
        posts,
        GetAllPosts
      };
    },
  };
  </script>
  
  <style>
  .header {
    display: flex;
    
    justify-content: center;
    align-items: center;
    height: 100px;
  }
  
  .posts-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 30px;
    padding: 20px;
  }
  
  .post {
    display: flex;
    width: 600px;
    min-height: 350px;
    flex-direction: column;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 30px;
  }
  .maker{
    color: darkblue;
    padding: 10px;
  }
  
  .post-image {
    height: 200px;
    overflow: hidden;
  }
  
  .post-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .post-content {
    padding: 20px;
  }
  
  .post-content h2 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: bold;
  }
  
  .post-content p {
    margin: 10px 0;
    font-size: 1rem;
  }
  </style>
  