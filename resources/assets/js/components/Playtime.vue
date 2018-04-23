<template>
    <div id="time">
        <span>{{ formatTime }}</span>/<span>{{ formatDuration }}</span>
    </div>
</template>

<script>
    export default {
        props: ['time', 'duration'],
        computed: {
            formatTime () {
                return this.timestampToTime(this.time);
            },
            formatDuration () {
                return this.timestampToTime(this.duration);
            }
        },
        methods: {
            timestampToTime (time) {
                const ms = time % 1000;
                time = (time - ms) / 1000;
                const secs = Math.floor(time % 60);
                time = (time - secs) / 60;
                const mins = Math.floor(time % 60);
                time = (time - mins) / 60;
                const hours = Math.floor(time % 24);

                return (hours > 0 ? hours + ':' : '') + (mins < 10 ? "0" + mins : mins) + ':' + (secs < 10 ? "0" + secs : secs);
            }
        },
    }
</script>

<style lang="scss" scoped>
    #time {
        position: absolute;
        bottom: 20px;

        span {
            margin: 0 10px;
            font-weight: 200;
        }
    }
</style>