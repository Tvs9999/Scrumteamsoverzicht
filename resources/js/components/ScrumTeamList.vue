<template>
  <div v-if="sortedClasses.length > 0">
    <div v-for="classData in sortedClasses" :key="classData.id" :ref="`class_${classData.id}`" class="class" :class="{ 'active': !areAllUsersPresent('class', classData.id) && active }" :data-id="classData.id">
      <div class="top">
        <h2>{{ classData.name }}</h2>
        <div class="buttons">
          <div v-if="active" :class="{ 'present': areAllUsersPresent('class', classData.id), 'absent': !areAllUsersPresent('class', classData.id) }">
            <i :class="{ 'fa-solid fa-check': areAllUsersPresent('class', classData.id), 'fa-solid fa-xmark': !areAllUsersPresent('class', classData.id) }"></i>
          </div>
          <!-- Bind click event to toggle 'active' class for classes -->
          <div class="fold-btn" @click="toggleClass('class', classData.id)" :class="{ 'active': !areAllUsersPresent('class', classData.id) && active }">
            <i class="fa-solid fa-chevron-down"></i>
          </div>
        </div>
      </div>
      <div class="scrumteams">
        <div v-for="team in classData.scrumteams" :key="team.id" :ref="`class_${classData.id}`" class="scrumteam" :class="{ 'active': !areAllUsersPresent('scrumteam', team.id) && active }" :data-id="team.id">
          <div class="top">
            <h3>{{ team.name }}</h3>
            <div class="buttons">
              <form v-if="active && !dashboard" :action="'/archive-scrumteam/' + team.id" method="POST">
                <input type="hidden" name="_token" :value="csrf">
                <input type="hidden" :value="team.id">
                <button type="submit"><i class="fa-solid fa-boxes-packing"></i></button>
              </form>
              <div v-if="active" :class="{ 'present': areAllUsersPresent('scrumteam', team.id), 'absent': !areAllUsersPresent('scrumteam', team.id) }">
                <i :class="{ 'fa-solid fa-check': areAllUsersPresent('class', classData.id), 'fa-solid fa-xmark': !areAllUsersPresent('class', classData.id) }"></i>
              </div>
              <!-- Bind click event to toggle 'active' class for scrumteams -->
              <div class="fold-btn" @click="toggleClass('scrumteam', team.id)" :class="{ 'active': !areAllUsersPresent('class', classData.id) && active }">
                <i class="fa-solid fa-chevron-down"></i>
              </div>
            </div>
          </div>
          <div class="members">
            <div v-for="(teamUser, userIndex) in team.users" :key="teamUser.id">
              <div class="member" :class="{ 'absent': teamUser.user.present === 0}">
                <i v-if="active"
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
  </div>
  <div v-else class="no-scrumteams">
    <p>Geen scrumteams gevonden</p>
  </div>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'ScrumTeamList',
  props: {
    classes: Array,
    active: Boolean,
    dashboard: Boolean,
  },
  data() {
    return {
      sortedClasses: [],
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    };
  },
  mounted(){
    console.log(this.dashboard)
    this.sortedClasses = this.classes.sort((classA, classB) => {
    const usersPresentInClassA = classA.scrumteams.every(team => this.areAllUsersPresent('scrumteam', team.id));
    const usersPresentInClassB = classB.scrumteams.every(team => this.areAllUsersPresent('scrumteam', team.id));
    
    if (usersPresentInClassA && !usersPresentInClassB) {
      return 1; // classA should come before classB
    } else if (!usersPresentInClassA && usersPresentInClassB) {
      return -1; // classB should come before classA
    } else {
      return 0; // No change in order
    }
  });


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
