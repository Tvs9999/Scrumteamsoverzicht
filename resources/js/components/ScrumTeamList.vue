<template>
  <div v-for="classData in classes" :key="classData.id" class="class" :class="{ 'active': !areAllUsersPresent('class', classData.id) }" :data-id="classData.id">
    <div class="top">
      <h2>{{ classData.name }}</h2>
      <div class="buttons">
        <div :class="{ 'present': areAllUsersPresent('class', classData.id), 'absent': !areAllUsersPresent('class', classData.id) }">
          <i :class="{ 'fa-solid fa-check': areAllUsersPresent('class', classData.id), 'fa-solid fa-xmark': !areAllUsersPresent('class', classData.id) }"></i>
        </div>
        <!-- Bind click event to toggle 'active' class for classes -->
        <div class="fold-btn" @click="toggleClass('class', classData.id)" :class="{ 'active': !areAllUsersPresent('class', classData.id) }">
          <i class="fa-solid fa-chevron-down"></i>
        </div>
      </div>
    </div>
    <div class="scrumteams">
      <div v-for="team in classData.scrumteams" :key="team.id" class="scrumteam" :class="{ 'active': !areAllUsersPresent('scrumteam', team.id) }" :data-id="team.id">
        <div class="top">
          <h3>{{ team.name }}</h3>
          <div class="buttons">
            <div :class="{ 'present': areAllUsersPresent('scrumteam', team.id), 'absent': !areAllUsersPresent('scrumteam', team.id) }">
              <i :class="{ 'fa-solid fa-check': areAllUsersPresent('class', classData.id), 'fa-solid fa-xmark': !areAllUsersPresent('class', classData.id) }"></i>
            </div>
            <!-- Bind click event to toggle 'active' class for scrumteams -->
            <div class="fold-btn" @click="toggleClass('scrumteam', team.id)" :class="{ 'active': !areAllUsersPresent('class', classData.id) }">
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
    toggleClass(type, id) {
      const clickedButton = event.target.closest('.fold-btn');
      if (clickedButton) {
        clickedButton.classList.toggle('active');
      }

      const element = document.querySelector(`.${type}[data-id="${id}"]`);
      if (element) {
        element.classList.toggle('active');
      }
    },
  },
});
</script>
