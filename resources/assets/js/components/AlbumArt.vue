<template>
    <div id="album-art">
        <div id="art">
            <img :src="image" />
        </div>

        <div id="background">
            <img :src="image" />
        </div>
    </div>
</template>

<script>
    export default {
        props: ['image']
    }
</script>

<style lang="scss" scoped>
    #album-art {
        #art {
            max-width: 500px;

            img {
                width: 100%;
            }
        }

        #background {
            z-index: -1;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            -webkit-filter: blur(15px);
            -moz-filter: blur(15px);
            -o-filter: blur(15px);
            -ms-filter: blur(15px);
            filter: blur(15px);

            img {
                width: 100%;
                min-height: 100%;
            }
        }
    }
</style>