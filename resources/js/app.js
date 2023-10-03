import { createApp } from 'vue';
import ScrumTeamList from './components/ScrumTeamList.vue';

import 'bootstrap';

var scrumteams = document.getElementById("scrumteamsList");
if (scrumteams){
const app = createApp({});

app.component('scrumteamlist', ScrumTeamList);

app.mount('#scrumteamsList');
}
