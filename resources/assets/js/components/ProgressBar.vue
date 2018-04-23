<template>
    <div id="progress-bar">
        <span :style="{ width: progress + '%' }"></span>
    </div>
</template>

<script>
    export default {
        props: ['position', 'duration'],
        computed: {
            progress () {
                return (this.position / this.duration) * 100;
            }
        }
    }
</script>

<style lang="scss" scoped>
    #progress-bar {
        position: fixed;
        bottom: 0;
        right: 0;
        left: 0;
        height: 10px;

        span {
            height: 100%;
            background-color: #00C21F;
            display: block;
            transition: width 1s linear;
        }
    }
</style>