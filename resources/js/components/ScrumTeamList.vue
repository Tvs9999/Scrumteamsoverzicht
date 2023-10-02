<template>
  <div>
    <div v-for="classData in classes" :key="classData.id" class="card mb-4">
      <div class="card-header">
        <h2 class="card-title" data-toggle="collapse" :data-target="'#class-' + classData.id">
          {{ classData.name }}
        </h2>
      </div>
      <div :id="'class-' + classData.id" class="collapse">
        <ul class="list-group list-group-flush">
          <li v-for="team in getTeamsByClass(classData.id)" :key="team.id" class="list-group-item">
            <h4 class="card-title" data-toggle="collapse" :data-target="'#team-' + team.id">
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
  name: 'ScrumTeamList',
  props: {
    classes: Array,
    scrumteams: Array,
    scrumteamuser: Array,
    students: Array,
  },
  mounted() {
    // console.log('Classes prop:', this.classes);
  },
  methods: {
    getTeamsByClass(classId) {
      // Filter scrum teams based on the class ID
      return this.scrumteams.filter(a => a.class_id === classId);
    },
    getTeamUsers(teamId) {
      // Filter team users based on the team ID
      const teamMembers = this.scrumteamuser
        .filter(user => user.team_id === teamId)
        .map(user => {
          // Find the corresponding student data based on user_id
          const student = this.students.find(student => student.id === user.user_id);
          return {
            // Include relevant user and student data in the result
            user,
            student,
          };
        });

      return teamMembers;
    }
    ,
  },
});
</script>

