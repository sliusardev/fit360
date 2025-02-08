import { Fancybox } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import Swiper from 'swiper';
// import Swiper styles
import 'swiper/css';

Fancybox.bind('[data-fancybox="gallery"]', {
    // Your custom options for a specific gallery
});

const swiper = new Swiper('.swiper', {
    direction: 'horizontal', // Slide direction
    loop: true, // Loop slides
});

