<template>
  <div class="container container-countdown text-center">
    <h2>Starladder Minor starts in</h2>

    <div id="clockdiv" class="countdown-timers">
      <div>
        <span class="days"></span>
        <div class="smalltext">Days</div>
      </div>
      <div>
        <span class="hours"></span>
        <div class="smalltext">Hours</div>
      </div>
      <div>
        <span class="minutes"></span>
        <div class="smalltext">Minutes</div>
      </div>
      <div>
        <span class="seconds"></span>
        <div class="smalltext">Seconds</div>
      </div>
    </div>
    <div class="legend row">
      <!--<div class="col-xs-6 col-md-2 col-md-offset-1">-->
        <!--<a class="button button-fullwidth button-link" target="_blank" href="https://www.twitch.tv/purgegamers">Purge Stream</a>-->
      <!--</div>-->
      <!--<div class="col-xs-6 col-md-2">-->
        <!--<a class="button button-fullwidth button-link" target="_blank" href="https://www.twitch.tv/day9tv">Day9 Stream</a>-->
      <!--</div>-->
      <!--<div class="col-xs-6 col-md-2">-->
        <!--<a class="button button-fullwidth button-link" target="_blank" href="https://www.reddit.com/r/DotA2/comments/5ioc9a/day9_learns_dota_with_purge_jan_18th_every/">Reddit Post</a>-->
      <!--</div>-->
      <!--<div class="col-xs-6 col-md-2">-->
        <!--<a class="button button-fullwidth button-link" target="_blank" href="/ical/Day9nPurge.ics">Calendar File</a>-->
      <!--</div>-->
      <div class="col-xs-6 col-xs-offset-3 col-md-2 col-md-offset-5">
        <a class="button button-fullwidth button-link" v-if="manual === 'true'" href="/">Want it live?</a>
        <a class="button button-fullwidth button-link" v-else href="/manual-timer">Want to hit F5?</a>
      </div>
      <!--<div class="col-md-2">-->
      <!--<a class="button button-fullwidth button-link" target="_blank" href="https://www.youtube.com/watch?v=guGFT27SavM">Monkey King Teaser</a>-->
      <!--</div>-->
      <!--<div class="col-md-2">-->
      <!--<a class="button button-fullwidth button-link" target="_blank" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">UI Preview by purge</a>-->
      <!--</div>-->
      <!--<div class="col-sm-12 text-center">
          <p>
              created by <a target="_blank" href="https://www.reddit.com/user/karreerose/">/u/karreerose</a>
          </p>
      </div>-->
    </div>
  </div>
</template>

<script>
  const moment = require('moment');

  export default {
    props: ['manual'],
    mounted() {
      const deadline = moment('20171011 17:00+2', 'YYYYMMDD hh:mm+Z');

//      console.log(this.getNextPurgeStream());

//      this.initializeClock('clockdiv', this.getNextPurgeStream());
      this.initializeClock('clockdiv', deadline);
    },
    methods: {
      getTimeRemaining(endtime) {
        const total = endtime.diff(moment());
        const seconds = Math.floor((total / 1000) % 60);
        const minutes = Math.floor((total / 1000 / 60) % 60);
        const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
        const days = Math.floor(total / (1000 * 60 * 60 * 24));

        return {
          total,
          days,
          hours,
          minutes,
          seconds,
        };
      },

      getNextPurgeStream() {
        const today = moment();
        const date = moment().utcOffset('-08:00').hour(13).minute(0).second(0).isoWeekday("Wednesday");

        // check if time is in the past
        if (today.diff(date) > 0) {
          // yes, it's in the past, lets add a week
          date.add(1, 'weeks');
        }

        return date;
      },

      initializeClock(id, endtime) {
        const clock = document.getElementById(id);
        const daysSpan = clock.querySelector('.days');
        const hoursSpan = clock.querySelector('.hours');
        const minutesSpan = clock.querySelector('.minutes');
        const secondsSpan = clock.querySelector('.seconds');

        const updateClock = () => {
          const t = this.getTimeRemaining(endtime);

          daysSpan.innerHTML = t.days;
          hoursSpan.innerHTML = (`0${t.hours}`).slice(-2);
          minutesSpan.innerHTML = (`0${t.minutes}`).slice(-2);
          secondsSpan.innerHTML = (`0${t.seconds}`).slice(-2);
        };

        updateClock();
        if (this.manual === 'false') {
          setInterval(updateClock, 1000);
        }
      },
    },
  };
</script>
