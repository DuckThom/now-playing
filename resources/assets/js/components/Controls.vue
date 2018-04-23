<template>
    <div id="controls">
        <div id="prev" v-on:click="prev()">
            <i class="fal fa-fw fa-step-backward"></i>
        </div>

        <div id="toggle" v-on:click="toggle()">
            <i class="fal fa-fw fa-pause" v-if="playing"></i>
            <i class="fal fa-fw fa-play" v-else></i>
        </div>

        <div id="next" v-on:click="next()">
            <i class="fal fa-fw fa-step-forward"></i>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['playing'],
        methods: {
            prev () {
                this.$root.$data.player.previousTrack();
            },
            toggle () {
                this.$root.$data.player.togglePlay();
            },
            next () {
                this.$root.$data.player.nextTrack();
            }
        }
    }
</script>

<style lang="scss" scoped>
    #controls {
        position: absolute;
        bottom: 70px;

        & > div {
            display: inline-block;
        }
    }
</style>