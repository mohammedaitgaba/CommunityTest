<template>
    <div class="comments-section">
      <div class="comment-form">
        <form class="form" @submit.prevent="addComment">
          <div class="form-group">
            <label for="message">Comment:</label>
            <input type="text" v-model="newComment" id="message"/>
          </div>
          <button type="submit">Submit</button>
        </form>
      </div>
  
      <div class="comments-list">
        <h3>Comments:</h3>
          <div v-for="comment in comments" :key="comment.id">
            <div v-if="comment.post_id === post_id">
                <div class="comment-body">{{ comment.content }}</div>
            </div>
          </div>
      </div>
    </div>
  </template>
  
<script>
import axios from 'axios';
import { ref,onMounted } from 'vue';


export default {
    name:'Comments',
    props: ["id"],
  setup(props) {
      const comments = ref([]);
      const newComment = ref('')
      const token =ref('')
    const post_id = ref(props.id)
      const id_user =ref()

    onMounted(() => {
        getTokenFromLocalStorage()
        getAllComments()
    });
    const getTokenFromLocalStorage = ()=>{
      if (localStorage.getItem('access_token')) {
        token.value = localStorage.getItem('access_token')
        id_user.value = localStorage.getItem('id')
      }
    }
      const getAllComments = async()=>{
          await axios('http://127.0.0.1:8000/api/getComments')
          .then(res=>{
            comments.value = res.data
          })
          .catch(err=>console.log(err.message))
      }
      const addComment= async()=>{
        const formData = {
            user_id:id_user.value,
            post_id:post_id.value,
            content :newComment.value
        }
        await axios.post('http://127.0.0.1:8000/api/NewComment',formData,{
            headers: {
            'Authorization':`Bearer ${token.value}`
        }
        })
          .then(res=>{
            if (res.data) {
                getAllComments()
                newComment.value = ""
            }
          })
          .catch(err=>console.log(err.message))
        }

    return {
      newComment,
      comments,
      post_id,
        addComment,
        getTokenFromLocalStorage,
        getAllComments
    };
  },
};
</script>
<style >
.comments-section{
    width: 100%;
    display: flex;
    flex-direction: column;
}
.comment-form{
    width: 100%;
    display: flex;
}
.form{
    display: flex;
    width: 100%;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}
.form-group{
    width: 100%;
}
#message{
    width: 90%;
}
</style>