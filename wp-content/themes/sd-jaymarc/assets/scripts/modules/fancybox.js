import { Fancybox } from "@fancyapps/ui/src/Fancybox/Fancybox.js";

export default {
	init () {

		Fancybox.defaults.Hash = false;
    Fancybox.defaults.touch = false;

    //$.fancybox.defaults.Thumbs = { autoStart : true };
    Fancybox.defaults.Thumbs = { autoStart : false };
    
    Fancybox.bind("[data-fancybox]", {
      Thumbs: {
        autoStart: false,
      },
      Carousel: {
        Panzoom: {
          touch: false,
        },
      },
    });

    Fancybox.bind('[data-fancybox*="modal"]', {
      mainClass: 'modal-full-width', 
      fullscreen: {
        autoStart: true,
      },
    });

    Fancybox.bind('[data-fancybox*="team"]', {
      Thumbs: {
        autoStart: false,
      },
      Carousel: {
        Panzoom: {
          touch: false,
        },
      },
    });

    
    
    Fancybox.bind('[data-fancybox="styles"]', {
      Thumbs: {
        autoStart: false,
      },
      Toolbar: {
        display: [
          "close",
        ],
      },
    });

	},
}