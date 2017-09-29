<template>
  <div class="container container-quiz">
    <div class="row">
      <div class="col-sm-12">
        <h4 class="text-center secondary">Your MMR: {{mmr}}</h4>
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
            <div v-if="correct">
              <h2>Correct!</h2>
              <p>{{answerTextSolution}}</p>
            </div>
            <div v-else>
              <h2>Nope! {{answerText}}</h2>
              <p>{{answerTextSolution}}</p>
            </div>

            <a v-on:click="fastTrack" class="button button-link">
              Next Question
            </a>
          </div>
        </div>
        <div class="col-sm-12" v-else>
          <div :class="`answers answers-${quiz.answers.length}`">
            <div class="answer" v-for="answer in quiz.answers">
              <a v-on:click="answerQuiz(answer.correct)" class="button button-link button-full-width">
                <img v-if="answer.image" :src="answer.image" alt="">
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

  .answered{
    width: 100%;
    max-width: 420px;
    margin: 0 auto;
  }

  .answers{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
  }

  .button{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .button img {
    max-width: 120px;
    border-radius: 4px;
    width: 100%;
    margin-bottom: 5px;
  }

  h3{
    font-weight: 300;
  }

  h3 b{
    font-weight: 700;
  }

  @media (max-width: 767px) {
    .answers-3 .answer {
      width: 100%;
    }

    .answers-4 .answer {
      width: 50%;
    }

    .button img {
      max-width: 30vw;
    }

    .button{
      font-size: 13px;
    }

    h3{
      font-size: 15px;
    }
  }

  .answer{
    min-width: 120px;
    padding: 5px 10px;
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
        answerTextSolution: '',
        mmr: window.serverData.quizMmr,
        timeoutId: null,
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
              this.answerTextSolution = correct.solution;
          } else {
            this.answerText = '';
            this.answerTextSolution = '';
          }

          this.answered = false;
        });
      },
      answerQuiz(answer) {
        console.log(answer);
        this.answered = true;
        this.correct = answer;

        this.$http.post(`${window.Laravel.apiUrl}/quiz`, {
          question_id: this.quiz.id,
          correct: answer,
          session: window.serverData.quizSession,
        });

        if (answer) {
            this.mmr += 25;
        } else {
            this.mmr -= 25;
        }

        this.timeoutId = setTimeout(() => {
           this.getQuizQuestion();
        }, 3000);
      },
      fastTrack() {
        if (this.timeoutId) {
          clearTimeout(this.timeoutId);
        }

        this.getQuizQuestion();
      },
    },
  };
</script>
