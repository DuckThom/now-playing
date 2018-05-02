<template>
    <div id="track-info">
        <div id="song">{{ song }}</div>

        <div id="artists">{{ artists }}</div>

        <div id="album">
            [{{ album }}]
        </div>
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

        #song {
            letter-spacing: -2px;
            padding: 5px 0;

            &:after {
                content: "by";
                display: block;
                font-size: 30px;
                font-style: italic;
                padding: 15px 0;
            }
        }

        #artists {
            padding: 5px 0 10px;
        }

        #album {
            letter-spacing: -2px;
        }
    }
</style>