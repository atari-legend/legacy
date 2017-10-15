(function($) {
    // Setup the SC68 backend and player
    // See: https://github.com/wothke/sc68-2.2.1/tree/master/emscripten
    // and: https://github.com/wothke/webaudio-player-1.0

    var sc68Backend = new SC68BackendAdapter();

    ScriptNodePlayer.createInstance(
        sc68Backend,
        '../../../data/music/games/',
        [],             // Required files (?)
        false,          // Enable spectrum analyzer
        function() {},  // Player ready
        function() {},  // Track ready to play
        function() {},  // On Track End
        function() {}); // On update

    var player = ScriptNodePlayer.getInstance();

    /**
     * Update the player UI with the current state of the player
     * @param playerElement jQuery root element for the player UI
     */
    function updateUi(playerElement) {
        // Update current track and track count
        playerElement.find('.current-track').text(playerElement.data('current-track') + 1);
        playerElement.find('.track-count').text(playerElement.data('track-count'));

        // Update play/pause button depending on the player state
        if (playerElement.data('playing') === true){
            playerElement.find('.track-play-stop i').addClass('fa-stop');
            playerElement.find('.track-play-stop i').removeClass('fa-play');
        } else {
            playerElement.find('.track-play-stop i').addClass('fa-play');
            playerElement.find('.track-play-stop i').removeClass('fa-stop');
        }
    }

    /**
     * Configure a music player for SND files on a given element.
     *
     * The player should have a previous, next, and play/stop button,
     * as well as SPANs to display the current track being played and
     * the total number of tracks
     */
    $.fn.sndPlayer = function() {
        this.each(function() {
            var playerElement = $(this);

            // Get ID and extension of music to play from the DOM
            var musicId = playerElement.data('music-id'),
                musicExt = playerElement.data('music-ext');

            // Initialise internal state
            playerElement.data('playing', false);
            playerElement.data('current-track', 0);

            // Handler when play/stop is clicked
            playerElement
                .find('.track-play-stop')
                .on('click', function() {
                    if (!playerElement.data('playing')) {

                        // Player is not playing, load a music file and start
                        // playback
                        player.loadMusicFromURL(
                            musicId + '.' + musicExt,
                            {},
                            function() {    // on file loaded

                                // Update out internal state
                                playerElement.data('track-count', player.getSongInfo().numberOfTracks);
                                playerElement.data('playing', true);

                                // Set track to play to currently selected track
                                // This needed when the song is stopped then resumed,
                                // to avoid restarting to the first track
                                sc68Backend.evalTrackOptions({
                                    track: playerElement.data('current-track')
                                });

                                updateUi(playerElement);

                                player.play();
                            },
                            function() {},  // on fail
                            function() {}   // on progress
                            );
                    } else {
                        player.pause();
                        playerElement.data('playing', false);
                        updateUi(playerElement);
                    }

                    // Prevent default click action
                    return false;
                });

            // Handler when next is clicked
            playerElement
                .find('.track-next')
                .on('click', function() {
                    // If we haven't reached the last track, go to current track + 1
                    // Note: Track indexes start at 0, but we want to display 1 on the front-end
                    if (playerElement.data('current-track') < playerElement.data('track-count') - 1) {
                        playerElement.data('current-track', playerElement.data('current-track') + 1);
                        sc68Backend.evalTrackOptions({
                            track: playerElement.data('current-track')
                        });

                        updateUi(playerElement);
                    }

                    // Prevent default click action
                    return false;
                });

            // Handler when previous is clicked
            playerElement
                .find('.track-prev')
                .on('click', function() {
                    // If we are not already on the first track, go to current track - 1
                    // Note: Track indexes start at 0, but we want to display 1 on the front-end
                    if (playerElement.data('current-track') > 0) {
                        playerElement.data('current-track', playerElement.data('current-track') - 1);
                        sc68Backend.evalTrackOptions({
                            track: playerElement.data('current-track')
                        });

                        updateUi(playerElement);
                    }

                    return false;
                });
        });
    }
}(jQuery));
