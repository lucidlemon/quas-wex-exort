<template>
    <div class="container">
        <h1>Time to 6.89 / 7.00 / the new journey / Monkey King</h1>
        <div id="clockdiv">
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
        <div class="legend">
            <p>Manual: {{manual}}</p>
            <p>
                Counting towards 2016·12·12 22:00 UTC<br><br>
                Sources:<br>
                <a target="_blank" href="http://blog.dota2.com/2016/10/the-fall-2016-battle-pass/">Confirmation of the date</a><br>
                <a target="_blank" href="https://www.youtube.com/watch?v=guGFT27SavM">Monkey King Teaser</a><br>
                <a target="_blank" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">UI Preview provided by purge</a>
                <br><br>


                <a v-if="manual === 'true'" href="/">if you don't wanna hit F5 all the time, go here</a>
                <a v-else href="/manual-timer">if you wanna hit F5 all the time, go here</a>

                
                <br><br>
                created by <a target="_blank" href="https://www.reddit.com/user/karreerose/">/u/karreerose</a>
            </p>
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
