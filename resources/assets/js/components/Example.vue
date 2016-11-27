<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        I'm an example component!
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        <p>
            Counting towards 2016·12·12 22:00 UTC<br><br>
            Sources:<br>
            <a target="_blank" href="http://blog.dota2.com/2016/10/the-fall-2016-battle-pass/">Confirmation of the date</a><br>
            <a target="_blank" href="https://www.youtube.com/watch?v=guGFT27SavM">Monkey King Teaser</a><br>
            <a target="_blank" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">UI Preview provided by purge</a>
            <br><br>
            <a href="index_reload.html">if you wanna hit F5 all the time, go here</a>
            <br><br>
            created by <a target="_blank" href="https://www.reddit.com/user/karreerose/">/u/karreerose</a>
        </p>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component ready.')
        }
    }
</script>
