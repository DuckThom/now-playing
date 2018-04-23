<template>
    <div id="track-info">
        <h2>{{ song }}</h2>

        <h3>{{ artists }}</h3>

        <h4>
            [{{ album }}]
        </h4>
    </div>
</template>

<script>
    export default {
        props: ['song', 'artists', 'album']
    }
</script>

<style lang="scss" scoped>
    #track-info {
        margin-left: 150px;
        width: 50vw;

        h2 {
            font-weight: 600;
            letter-spacing: -2px;
            padding: 5px 0;

            &:after {
                content: "by";
                display: block;
                font-size: 30px;
                font-weight: 200;
                font-style: italic;
                padding: 15px 0;
            }
        }

        h3 {
            font-weight: 400;
            padding: 5px 0 10px;
        }

        h4 {
            font-weight: 200;
            letter-spacing: -2px;
        }
    }
</style>