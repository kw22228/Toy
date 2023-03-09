export default class CoreAudioPlayer {
  #targetNode;
  #audio;
  #progressbar;
  #progress;

  #isPlay = false;
  #isDragging = false;
  #playStartTime = null;
  #newProgressPercent = 0;

  constructor($customPlayer) {
    this.#progressbar = $customPlayer.querySelector(".mini_player_seekbar");
    this.#progress = $customPlayer.querySelector(".player_play");

    this.#progressbar.addEventListener("dragstart", (e) => this.dragStart(e));
    this.#progressbar.addEventListener("drag", (e) => this.drag(e));
    this.#progressbar.addEventListener("dragend", (e) => this.dragEnd(e));
  }

  setNode($targetNode) {
    if (this.#targetNode === $targetNode) {
      // 다시 재생

      if (this.#isPlay) {
        this.#audio.pause();
        this.#isPlay = false;
        return;
      }

      this.#audio.play();
      this.#isPlay = true;
      return;
    }

    this.#targetNode = $targetNode;
    this.changeAudio($targetNode);
  }

  changeAudio($targetNode) {
    if (this.#isPlay) {
      this.stop();
      this.#isPlay = false;
    }

    this.#audio = this.#targetNode.querySelector("audio");
    this.#audio.addEventListener("timeupdate", this.updateProgress.bind(this));
    this.play();
    this.#isPlay = true;
  }

  play() {
    this.#audio.play();
    this.#playStartTime = Date.now();
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
    const elapsedTime = Date.now() - this.#playStartTime;
    const progressPercent = (elapsedTime / (duration * 1000)) * 100;

    this.#progress.style.width = `${progressPercent}%`;
  }

  dragStart({ clientX }) {
    if (this.#isPlay) this.puase();
    this.#isDragging = true;
  }

  drag({ clientX }) {
    if (this.#isDragging) {
      const progressBarWidth = this.#progressbar.offsetWidth;
      const deltaX = clientX;
      const newProgressPercent = (deltaX / progressBarWidth) * 100;

      if (newProgressPercent > 100) {
        this.#progress.style.width = "100%";
      } else if (newProgressPercent < 0) {
        this.#progress.style.width = "0%";
      } else {
        this.#progress.style.width = `${newProgressPercent}%`;
      }

      this.#newProgressPercent = newProgressPercent;
    }
  }

  dragEnd({ clientX }) {
    if (this.#isDragging) {
      this.#audio.currentTime =
        (this.#newProgressPercent * this.#audio.duration) / 100;
    }

    this.#isDragging = false;
  }
}
