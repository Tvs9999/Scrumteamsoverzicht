<template>
  <div>
    <div v-for="classData in classes" :key="classData.id" class="card mb-4">
      <div class="card-header">
        <h2 class="card-title">
          {{ team.name }}
          </h2>
      </div>
      <div :id="'class-' + classData.id" class="collapse">
        <ul class="list-group list-group-flush">
          <li v-for="team in getTeamsByClass(classData.id)" :key="team.id" class="list-group-item">
            <h4 class="card-title">
              {{ team.name }}
              
            </h4>
            <div :id="'team-' + team.id" class="collapse">
              <ul class="list-unstyled">
                <li v-for="teamUser in getTeamUsers(team.id)" :key="teamUser.id">
                  <i
                    :class="{ 'fas fa-check text-success': teamUser.student.present === 1, 'fas fa-times text-danger': teamUser.student.present === 0 }"></i>
                  {{ teamUser.student.firstname }}
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    classes: Array,
    scrumteams: Array,
    scrumteamUser: Array,
    students: Array,
  },  mounted() {
    console.log('Classes prop:', this.classes);
  },
  methods: {
    getTeamsByClass(classId) {
      // Filter scrum teams based on the class ID
      return this.scrumteams.filter(team => team.class_id === classId);
    },
    getTeamUsers(teamId) {
      // Filter team users based on the team ID
      return this.scrumteamUser.filter(teamUser => teamUser.team_id === teamId);
    },
  }
});
</script>