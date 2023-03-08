export default class CoreAudioPlayer {
  #targetAudio;

  constructor() {}

  set targetAudio(targetAudio) {
    this.#targetAudio = targetAudio;
  }

  get targetAudio() {
    return this.#targetAudio;
  }
}
