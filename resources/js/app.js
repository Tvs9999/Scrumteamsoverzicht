import { createApp } from 'vue';
import ScrumTeamList from './components/ScrumTeamList.vue';

import 'bootstrap';

const app = createApp({});

app.component('scrumteamlist', ScrumTeamList);

app.mount('#scrumteams');
