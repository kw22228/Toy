import { AudioPlayer, SafariAudioPlayer } from "@class";
import { IS_SAFARI } from "@/constant";

function audioInit() {
  const $customPlayer = document.querySelector(".mini_player");
  const audioInstance = IS_SAFARI
    ? new SafariAudioPlayer($customPlayer)
    : new AudioPlayer($customPlayer);

  document.querySelectorAll(".btn_area").forEach((btn) => {
    btn.addEventListener("click", ({ target }) => {
      const $targetNode = target.closest(".news_node");

      audioInstance.setNode($targetNode);
    });
  });
}

document.addEventListener("DOMContentLoaded", audioInit);
