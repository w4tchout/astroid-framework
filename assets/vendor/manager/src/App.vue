<script setup>
import Heading from "@/components/Heading.vue";
import Container from "./components/Container.vue";
import { library } from '@fortawesome/fontawesome-svg-core'
import { faCircle, faArrowsLeftRight, faTrash, faDownload } from "@fortawesome/free-solid-svg-icons";
import { onBeforeMount, provide, ref } from "vue";
import { Tooltip, Toast, Modal } from 'bootstrap/js/index.esm'
import 'bootstrap/scss/bootstrap.scss'
import './assets/base.scss'
library.add(faCircle, faArrowsLeftRight, faTrash, faDownload);
const astroid_config = JSON.parse(document.getElementById("astroid-script-options").innerHTML);
const theme = ref('light');
provide('theme', theme);
provide('constant', astroid_config.astroid_lib);
provide('language', astroid_config.astroid_lang);
window.Tooltip = Tooltip;
window.Toast = Toast;
window.Modal = Modal;
onBeforeMount(()=>{
  const colorMode = getCookie('astroid_colormode');
  if (colorMode) {
    theme.value = colorMode;
  }
})

function updateColorMode(value) {
  theme.value = value;
  document.getElementById("astroid-html").setAttribute("data-bs-theme", value);
  setCookie('astroid_colormode', value, 3)
}

const setCookie = function (name, value, days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else var expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

const getCookie = function (name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}
</script>
<template>
  <Heading :config="astroid_config" @update:ColorMode="updateColorMode" />
  <Container :config="astroid_config" />
</template>