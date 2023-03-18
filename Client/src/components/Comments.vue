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
          <div  v-for="comment in comments" :key="comment.id">
            <div class="comment" v-if="comment.post_id === post_id">
                <div class="comment-body">
                  <div class="content">
                    {{ comment.content }}
                  </div>
                  <div class="actions" v-if="comment.user_id==id_user">
                    <p @click="updateComment">update</p>
                    <p @click="deleteComment(comment.id)">delete</p>
                  </div>
                </div>
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

        const deleteComment= async (id)=>{
          await axios.delete(`http://127.0.0.1:8000/api/deleteComment/${id}`,{
            headers: {
            'Authorization':`Bearer ${token.value}`
          }
        })
        .then(res=>{
            if (res.data) {
                getAllComments()
            }
          })
          .catch(err=>console.log(err.message))
        }

    return {
      newComment,
      comments,
      post_id,
      id_user,
        addComment,
        getTokenFromLocalStorage,
        getAllComments,
        deleteComment
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
.comment{
  padding: 10px;
}
.form{
    display: flex;
    width: 100%;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
}
.form-group{
    width: 100%;
}
.comment-body{
  display: flex;
  justify-content: space-between;
  background-color: rgb(243, 243, 243);
  padding: 20px 0 20px 0 ;
}
#message{
    width: 90%;
}
.content{
  max-width: 80%;
}
.actions{
  display: flex;
  gap: 20px;
  cursor: pointer;
}
</style>