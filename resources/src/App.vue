<template>
  <div id="app">
    <div v-if="isLoading" class="loading-container">
      <i class="fas fa-graduation-cap fa-spin loading-icon"></i>
    </div>
    <div v-else>
      <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm modern-navbar">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold text-dark-blue" href="#">SWGCC</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <button class="btn btn-outline-primary" @click="redirectToLogin">Iniciar Sesión</button>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <main class="container mt-5 pt-5">
        <section class="expertise-section mb-5">
          <div class="expertise-container">
            <div class="expertise-content animate__animated animate__fadeInLeft">
              <h1>Bienvenidos a SWGCC</h1>
              <p>Sistema Web para la Gestión de Cursos de Capacitación para estudiantes de la Carrera de Software</p>
              <button class="get-started-btn" @click="redirectToLogin">Iniciar Sesión</button>
            </div>
            <div class="expertise-image-container animate__animated animate__fadeInRight">
              <img src="../../public/uploads/images/UG.png" alt="Expert" />
            </div>
          </div>
        </section>

        <section id="about" class="mb-5">
          <div class="row">
            <div class="col-md-4" v-for="(card, index) in aboutCards" :key="index">
              <div class="card mb-4 animate__animated animate__fadeInUp h-100" :class="`animate__delay-${index}s`">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">{{ card.title }}</h5>
                  <p class="card-text flex-grow-1">{{ card.text }}</p>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>

      <footer class="bg-light text-center py-4">
        <div class="container">
          <p class="mb-0">&copy; 2024 Facultad de Ciencias Matemáticas y Físicas - Universidad de Guayaquil. Todos los derechos reservados.</p>
        </div>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const isLoading = ref(true);

const aboutCards = [
  { title: 'Cursos impartidos por docentes', text: 'Nuestros cursos son ofertados por el conjunto de docentes de la carrera de software. Garantizando la calidad del contenido de aprendizaje.' },
  { title: 'Aprendizaje continuo', text: 'Realizar los cursos expuestos en la plataforma agrega valioso conocimiento a tu stack tecnologico, agregando valor a tu hoja de vida.' },
  { title: 'Acceso 24/7', text: 'Accede a nuestros cursos en cualquier momento y desde cualquier lugar, con la flexibilidad de aprender a tu propio ritmo.' }
];

const redirectToLogin = () => {
  window.location.href = '/admin/auth/login';
};

onMounted(() => {
  setTimeout(() => {
    isLoading.value = false;
  }, 3000);
});
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;600&display=swap');
@import 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css';
@import 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css';

body {
  font-family: 'Figtree', sans-serif;
  padding-top: 56px;
}

.navbar {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: background-color 0.3s ease-in-out;
}

.navbar-brand {
  font-weight: bold;
  color: #003366;
}

.nav-link {
  transition: color 0.3s ease-in-out;
}

.nav-link:hover {
  color: #003366;
}

.expertise-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 2rem;
}

.expertise-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  flex-wrap: wrap;
}

.expertise-content {
  max-width: 50%;
}

.expertise-content h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.expertise-content p {
  font-size: 1.25rem;
  margin-bottom: 2rem;
}

.get-started-btn {
  background-color: #007bff;
  color: white;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 0.25rem;
  cursor: pointer;
}

.get-started-btn:hover {
  background-color: #0056b3;
}

.expertise-image-container {
  position: relative;
  max-width: 50%;
}

.expertise-image-container img {
  max-width: 100%;
  border-radius: 1rem;
}

.card {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s, box-shadow 0.3s;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.card:hover {
  transform: translateY(-10px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card-body {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

footer {
  background-color: #f8f9fa;
}

.text-dark-blue {
  color: #003366;
}

.bg-dark-blue {
  background-color: #003366;
}

.bg-light-blue {
  background-color: #3366cc;
}

.expertise-content,
.expertise-image-container,
.card {
  animation-duration: 1s;
}

.hero-section {
  animation-duration: 2s;
}

.loading-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: rgba(255, 255, 255, 0.8);
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 9999;
}

.loading-icon {
  font-size: 3rem;
  color: #003366;
}

.mt-5 {
  margin-top: 3rem !important;
}

.pt-5 {
  padding-top: 3rem !important;
}

@media (max-width: 768px) {
  .expertise-content, .expertise-image-container {
    max-width: 100%;
    text-align: center;
  }

  .expertise-container {
    flex-direction: column;
    align-items: center;
  }

  .get-started-btn {
    margin-top: 1rem;
  }
}
</style>