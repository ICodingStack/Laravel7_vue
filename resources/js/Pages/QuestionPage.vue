<template>
   <div>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

       <div class="container">
           <question :question="question" />

       </div>
       <div class="container">
           <div class="row justify-content-center">
               <div class="col-md-12">
                   <answers :question="question" />
               </div>
           </div>
       </div>
   </div>
</template>

<script>
import Question from '../components/Question';
import Answers from '../components/Answers';
export default {
    props: ['question'],
    components: {
        Question,
        Answers
    }
}
</script>
