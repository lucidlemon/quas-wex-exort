<template>
    <div class="container container-countdown text-center">
        <h2>Time to 6.89 / 7.00 / Monkey King</h2>
        <h4 class="sub">Counts down to 2016·12·12 22:00 UTC.<br>The date was <a target="_blank" href="http://blog.dota2.com/2016/10/the-fall-2016-battle-pass/">confirmed by valve</a>.</h4>

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
            <div class="col-md-2 col-md-offset-3">
                <a class="button button-fullwidth button-link" v-if="manual === 'true'" href="/">Want it live?</a>
                <a class="button button-fullwidth button-link" v-else href="/manual-timer">Want to hit F5?</a>
            </div>
            <div class="col-md-2">
                <a class="button button-fullwidth button-link" target="_blank" href="https://www.youtube.com/watch?v=guGFT27SavM">Monkey King Teaser</a>
            </div>
            <div class="col-md-2">
                <a class="button button-fullwidth button-link" target="_blank" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">UI Preview by purge</a>
            </div>
            <!--<div class="col-sm-12 text-center">
                <p>
                    created by <a target="_blank" href="https://www.reddit.com/user/karreerose/">/u/karreerose</a>
                </p>
            </div>-->
        </div>
    </div>
</template>

<script>
    var moment = require('moment');

    export default {
        props: ['manual'],
        mounted() {
            console.log('Component ready.');
            var deadline = moment('20161212 22:00+07:00', 'YYYYMMDD hh:mm+Z').toDate();
            deadline = moment(1481475600).toDate();
            this.initializeClock('clockdiv', deadline);

            this.$http.get('/api/user')
                    .then(response => {
                console.log(response.data);
            });
        },
        methods: {
            getTimeRemaining: function (endtime) {
                var t = Date.parse(endtime) - Date.parse(new Date());
                var seconds = Math.floor((t / 1000) % 60);
                var minutes = Math.floor((t / 1000 / 60) % 60);
                var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
                var days = Math.floor(t / (1000 * 60 * 60 * 24));
                return {
                    'total': t,
                    'days': days,
                    'hours': hours,
                    'minutes': minutes,
                    'seconds': seconds
                };
            },

            initializeClock: function(id, endtime) {
                var clock = document.getElementById(id);
                var daysSpan = clock.querySelector('.days');
                var hoursSpan = clock.querySelector('.hours');
                var minutesSpan = clock.querySelector('.minutes');
                var secondsSpan = clock.querySelector('.seconds');

                var updateClock = () => {
                    var t = this.getTimeRemaining(endtime);

                    daysSpan.innerHTML = t.days;
                    hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
                    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

                    if (t.total <= 0) {
                        clearInterval(timeinterval);
                    }
                }

                updateClock();
                if(this.manual === 'false'){
                    var timeinterval = setInterval(updateClock, 1000);
                }
            }
        }
    }
</script>
