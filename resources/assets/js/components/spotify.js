spotify = {};

var $loader = document.getElementById('loader');
var $image = document.getElementById('art');
var $imageBlur = document.getElementById('art-bg');
var $progressLine = document.getElementById('line');
var $track = document.getElementById('track');
var $artist = document.getElementById('artist');
var $album = document.getElementById('album');
var $wave = document.getElementById('wave');
var $playIcon = document.getElementById('play-icon');
var $pauseIcon = document.getElementById('pause-icon');
var $currentPlaytime = document.getElementById('current-playtime');
var $totalPlaytime = document.getElementById('total-playtime');

spotify.fetch = function () {
    axios.get('/fetch')
        .then(function (response) {
            if (response.data.success) {
                var payload = response.data.payload;

                if (payload === "") {
                    $loader.style.opacity = 1;

                    $loader.textContent = "No song is currently playing";
                } else {
                    $loader.style.opacity = 0;

                    payload = JSON.parse(payload);

                    if (payload.redirect) {
                        window.location.replace(payload.redirect);
                    }

                    if (payload.is_playing) {
                        $pauseIcon.style.display = "none";
                        $playIcon.style.display = "block";
                        $wave.style.opacity = 1;
                    } else {
                        $pauseIcon.style.display = "block";
                        $playIcon.style.display = "none";
                        $wave.style.opacity = 0;
                    }

                    // Set the album art
                    var image = payload.item.album.images[0].url;
                    $image.setAttribute('src', image);
                    $imageBlur.setAttribute('src', image);

                    // Set the track progress
                    $progressLine.style.width = calculateProgress(payload.progress_ms, payload.item.duration_ms) + "%";

                    // Set the track name
                    $track.textContent = payload.item.name;

                    // Set the artist name
                    $artist.textContent = payload.item.artists[0].name;

                    // Set the album name
                    $album.textContent = payload.item.album.name;

                    // Set the current and total playtime
                    $currentPlaytime.textContent = msToTime(payload.progress_ms);
                    $totalPlaytime.textContent = msToTime(payload.item.duration_ms);
                }
            }
        })
        .catch(function (error) {
            alert("Whoops, something went wrong...");

            window.location.href = "/";
        });
};

setInterval(function () {
    spotify.fetch();
}, 1000);
spotify.fetch();

/**
 *
 * @param current
 * @param total
 * @returns {number}
 */
function calculateProgress(current, total) {
    return (current / total) * 100;
}

function msToTime(time) {
    var ms = time % 1000;
    time = (time - ms) / 1000;
    var secs = time % 60;
    time = (time - secs) / 60;
    var mins = time % 60;

    return mins + ':' + (secs < 10 ? "0" + secs : secs);
}