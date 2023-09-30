import { createApp } from 'vue';
import ScrumTeamList from './components/ScrumTeamList.vue';

import 'bootstrap';

var scrumteams = document.getElementById("scrumteams");
if (scrumteams){
const app = createApp({});

app.component('scrumteamlist', ScrumTeamList);

app.mount('#scrumteams');
}
