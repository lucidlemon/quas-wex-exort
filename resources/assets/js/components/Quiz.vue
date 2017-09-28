<template>
  <div class="container container-quiz">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="text-center secondary">Test your knowledge</h2>
      </div>
    </div>

    <div class="oneliner-line text-center" v-if="quiz">
      <div class="row">
        <!--<div class="col-sm-12">-->
          <!--<div class="images">-->
            <!--<div class="image" v-for="image in quiz.images">-->
              <!--<img :src="image">-->
            <!--</div>-->
          <!--</div>-->
        <!--</div>-->
        <div class="col-sm-12">
          <h3 v-html="quiz.question"></h3>
        </div>
        <div class="col-sm-12" v-if="answered">
          <div class="answered">
            <h2 v-if="correct">Correct!</h2>
            <h2 v-else>Nope! {{answerText}}</h2>
          </div>
        </div>
        <div class="col-sm-12" v-else>
          <div class="answers">
            <div class="answer" v-for="answer in quiz.answers">
              <a v-on:click="answerQuiz(answer.correct)" class="button button-link button-full-width">
                {{answer.text}}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
  p{
    max-width: 100%;
  }

  .answers{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
  }

  .answer{
    min-width: 120px;
    margin: 10px;
  }
</style>

<script>
  import _ from 'lodash';

  export default {
    mounted() {
      this.getQuizQuestion();
    },
    data() {
      return {
        quiz: null,
        user: window.Laravel.user,
        answered: false,
        correct: false,
        answerText: '',
      };
    },
    methods: {
      getQuizQuestion() {
        // the id guarantees that the next oneliner won't be the same'
        this.$http.get(`${window.Laravel.apiUrl}/quiz/`).then((response) => {
          // success callback
          this.quiz = response.body;

          let correct = _.find(this.quiz.answers, 'correct');

          if (typeof correct !== 'undefined'){
              this.answerText = correct.text;
          }

        });
      },
      answerQuiz(answer) {
        console.log(answer);
        this.answered = true;
        this.correct = answer;

        setTimeout(() => {
           this.answered = false;
           this.getQuizQuestion();
        }, 3000);
      },
    },
  };
</script>
