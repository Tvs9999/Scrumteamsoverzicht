<template>
  <div v-for="classData in classes" :key="classData.id" class="class" :class="{'active': !areAllUsersPresent('class', classData.id) || classStates[classData.id]}">
    <div class="top">
      <h2>{{ classData.name }}</h2>
      <div class="buttons">
        <div :class="{ 'present': areAllUsersPresent('class', classData.id), 'absent': !areAllUsersPresent('class', classData.id) }">
          <i :class="{ 'fa-solid fa-check': areAllUsersPresent('class', classData.id), 'fa-solid fa-xmark': !areAllUsersPresent('class', classData.id) }"></i>
        </div>
        <!-- Bind click event to toggleClassCollapse method for classes -->
        <div class="fold-btn" :class="{ 'active': classStates[classData.id] }" @click="toggleClassCollapse('class', classData.id)">
            <i class="fa-solid fa-chevron-down"></i>
        </div>
      </div>
    </div>
    <div class="scrumteams">
      <div v-for="team in classData.scrumteams" :key="team.id" class="scrumteam" :class="{'active': !areAllUsersPresent('scrumteam', team.id) || scrumteamStates[classData.id][team.id]}">
        <div class="top">
          <h3>{{ team.name }}</h3>
          <div class="buttons">
            <div :class="{ 'present': areAllUsersPresent('scrumteam', team.id), 'absent': !areAllUsersPresent('scrumteam', team.id) }">
              <i :class="{ 'fa-solid fa-check': areAllUsersPresent('class', classData.id), 'fa-solid fa-xmark': !areAllUsersPresent('class', classData.id) }"></i>
            </div>
            <!-- Bind click event to toggleClassCollapse method for scrumteams -->
            <div class="fold-btn" :class="{ 'active': scrumteamStates[classData.id][team.id] }" @click="toggleClassCollapse('scrumteam', team.id, classData.id)">
              <i class="fa-solid fa-chevron-down"></i>
            </div>
          </div>
        </div>
        <div class="members">
          <div v-for="(teamUser, userIndex) in team.users" :key="teamUser.id">
            <div class="member" :class="{ 'absent': teamUser.user.present === 0}">
              <i
                :class="{ 'fas fa-check': teamUser.user.present === 1, 'fas fa-times': teamUser.user.present === 0 }"
              ></i>
              <p>{{ teamUser.user.firstname }}</p>
            </div>
            <!-- Conditionally render the divider if this is not the last teamUser -->
            <div v-if="userIndex < team.users.length - 1" class="divider"></div>
          </div>
        </div>
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
    // scrumteams: Array,
    // scrumteamuser: Array,
    // students: Array,
  },
  data() {
    return {
      classStates: {},
      scrumteamStates: {},
    };
  },
  mounted() {
    if (this.classes) {
      this.classes.forEach(classData => {
        console.log('classData:', classData); // Log classData to check its structure
        this.classStates[classData.id] = false; // Initially closed

        // Initialize scrumteamStates for each class
        this.scrumteamStates[classData.id] = {};
        classData.scrumteams.forEach(team => {
          console.log('team:', team); // Log team to check its structure
          this.scrumteamStates[classData.id][team.id] = false; // Initially closed for each scrum team
        });
      });
    }
  },
  methods: {
    areAllUsersPresent(type, id) {
      if (type === 'class') {
        const classData = this.classes.find(classData => classData.id === id);
        if (classData) {
          return classData.scrumteams.every(scrumTeam =>
            scrumTeam.users.every(user => user.user.present === 1)
          ); 
        }
      } else if (type === 'scrumteam') {
        const scrumTeam = this.classes
          .flatMap(classData => classData.scrumteams)
          .find(team => team.id === id);

        if (scrumTeam) {
          return scrumTeam.users.every(user => user.user.present === 1);
        }
      }

      return false;
    },


    // ... other methods ...
    toggleClassCollapse(type, id, classId) {
      console.log('Toggle clicked for', type, id);
      if (type === 'class') {
        // Toggle the class state
        this.classStates[id] = !this.classStates[id];
      } else if (type === 'scrumteam') {
        // Toggle the scrumteam state for the specific class and team
        this.scrumteamStates[classId][id] = !this.scrumteamStates[classId][id];
      }
      console.log('Updated classStates:', this.classStates);
      console.log('Updated scrumteamStates:', this.scrumteamStates);
    },
  }


    //   return notAllMembersPresent;
    // },
    // getClassIcon(teamId) {
    //   // Determine the icon class based on the check
    //   return this.allMembersPresent(teamId) ? 'fa-solid fa-xmark text-danger' : 'fa-solid fa-check-circle text-success';
    // },
    // getTeamsByClass(classId) {
    //   // Filter scrum teams based on the class ID
    //   return this.scrumteams.filter(a => a.class_id === classId);
    // },
    // getTeamUsers(teamId) {
    //   // Filter team users based on the team ID
    //   return this.scrumteamuser.filter(user => user.scrumteam_id === teamId);
    // },
});
</script>