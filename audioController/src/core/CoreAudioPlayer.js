export default class CoreAudioPlayer {
  #targetNode;
  #audio;
  #progressbar;
  #progress;
  #progress_point;
  #timeStart;
  #timeEnd;
  #button;
  #image;

  IS_PLAY = false;
  playStartTime = null;

  constructor($customPlayer) {
    this.#progressbar = $customPlayer.querySelector(".mini_player_seekbar");
    this.#progress = $customPlayer.querySelector(".player_play");
    this.#progress_point = $customPlayer.querySelector(".player_point");
  }

  setNode($targetNode) {
    if (this.#targetNode === $targetNode) {
      // 다시 재생

      if (this.IS_PLAY) {
        this.#audio.pause();
        this.IS_PLAY = false;
        return;
      }

      this.#audio.play();
      this.IS_PLAY = true;
      return;
    }

    this.#targetNode = $targetNode;
    this.changeAudio($targetNode);
  }

  changeAudio($targetNode) {
    if (this.IS_PLAY) {
      this.stop();
      this.IS_PLAY = false;
    }

    this.#audio = this.#targetNode.querySelector("audio");
    this.#audio.addEventListener("timeupdate", this.updateProgress.bind(this));
    this.play();
    this.IS_PLAY = true;
  }

  play() {
    this.#audio.play();
    this.playStartTime = Date.now();
    this.updateProgress();
  }

  puase() {
    this.#audio.pause();
  }

  stop() {
    this.#audio.pause();
    this.#audio.currentTime = 0;
    this.#progress.style.width = "0%";
  }

  updateProgress() {
    const { currentTime, duration } = this.#audio;
    const elapsedTime = Date.now() - this.playStartTime;
    const progressPercent = (elapsedTime / (duration * 1000)) * 100;

    this.#progress.style.width = `${progressPercent}%`;
  }
}
