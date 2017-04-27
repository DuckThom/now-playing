<div id="play">
    <div class='sp sp-wave' id="wave"></div>
    <i class="fa fa-play fa-fw" id="play-icon" aria-hidden="true"></i>
    <i class="fa fa-pause fa-fw" id="pause-icon" aria-hidden="true"></i>
</div>

<div class="album-art">
    @include('components.panel.art')
</div>

<div class="track-info">
    @include('components.panel.track')
</div>

<div id="playtime">
    <span id="current-playtime">00:00</span>/<span id="total-playtime">00:00</span>
</div>

<div id="progress">
    <span id="line"></span>
</div>