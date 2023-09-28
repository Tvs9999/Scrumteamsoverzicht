import { createApp } from 'vue';
import ScrumTeamList from './components/ScrumTeamList.vue';
import 'bootstrap';

const app = createApp({});

app.component('ScrumTeamList', ScrumTeamList);

app.mount('#scrumteams');
