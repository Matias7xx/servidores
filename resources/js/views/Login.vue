<template>
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-4 sm:pt-0 px-4 sm:px-6 bg-gradient-to-b from-gray-50 to-gray-200">

    <!-- Logo e título -->
    <div class="relative z-10 mb-6 sm:mb-8 flex flex-col items-center">
      <img
        src="/images/brasao_pcpb.png"
        alt="Brasão PCPB"
        class="w-24 sm:w-32 lg:w-40 h-auto drop-shadow-lg flex-shrink-0"
      />

      <div class="mt-2 sm:mt-3 text-center">
        <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800">Recursos Humanos | Servidores</h1>
      </div>
    </div>

    <!-- Card de Login -->
    <div class="w-full max-w-sm sm:max-w-md px-4 sm:px-6 py-6 sm:py-8 bg-white shadow-xl sm:rounded-lg relative z-10 border border-gray-200">

      <!-- Mensagem de status -->
      <div v-if="status" class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 rounded-lg text-green-700 text-sm">
        {{ status }}
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-4 sm:space-y-6">
        <!-- Matrícula -->
        <div class="relative">
          <label for="matricula" class="block text-sm font-medium text-gray-700 mb-2">
            Matrícula
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
              </svg>
            </div>
            <input
              id="matricula"
              v-model="form.matricula"
              type="text"
              :class="[
                'pl-10 pr-4 block w-full border rounded-md shadow-sm transition-colors duration-200 py-2 sm:py-3 text-sm sm:text-base matricula-input',
                errors.matricula
                  ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                  : 'border-gray-300 focus:border-[#c1a85a] focus:ring-[#c1a85a]'
              ]"
              required
              autofocus
              placeholder="Informe sua Matrícula"
              :disabled="loading"
            />
          </div>
          <div v-if="errors.matricula" class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-600">
            {{ errors.matricula[0] }}
          </div>
        </div>

        <!-- Senha -->
        <div class="relative">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            Senha
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <input
              id="password"
              ref="passwordInput"
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              :class="[
                'pl-10 pr-10 block w-full border rounded-md shadow-sm transition-colors duration-200 py-2 sm:py-3 text-sm sm:text-base',
                errors.password
                  ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                  : 'border-gray-300 focus:border-[#c1a85a] focus:ring-[#c1a85a]'
              ]"
              required
              placeholder="••••••••"
              :disabled="loading"
              autocomplete="current-password"
              :aria-describedby="errors.password ? 'password-error' : null"
              @keydown="checkCapsLock"
              @keyup="checkCapsLock"
              @focus="initCapsLockDetection"
              @blur="capsLockOn = false"
            />
            <button
              type="button"
              @click="togglePasswordVisibility"
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#c1a85a] focus:ring-offset-1 rounded transition-colors duration-200"
              :aria-label="showPassword ? 'Ocultar senha' : 'Mostrar senha'"
              tabindex="0"
            >
              <svg v-if="showPassword" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
              </svg>
              <svg v-else class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>

          <!-- Aviso de Caps Lock -->
          <div v-if="capsLockOn" class="mt-1 sm:mt-2 flex items-center text-xs sm:text-sm text-amber-600 bg-amber-50 p-2 rounded-md border border-amber-200">
            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
            <span>Caps Lock está ativo</span>
          </div>

          <div v-if="errors.password" id="password-error" class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-600">
            {{ errors.password[0] }}
          </div>
        </div>

        <!-- Lembrar-me -->
        <div class="flex items-center">
          <input
            id="remember"
            v-model="form.remember"
            type="checkbox"
            class="rounded border-gray-300 h-4 w-4 text-[#c1a85a] focus:ring-[#c1a85a]"
          />
          <label for="remember" class="ml-2 text-sm text-gray-600">Lembrar-me</label>
        </div>

        <div class="flex flex-col space-y-3 sm:space-y-4">
          <!-- Botão de Login -->
          <button
            type="submit"
            :class="[
              'w-full flex items-center justify-center space-x-2 px-6 py-2 sm:py-3 bg-[#c1a85a] text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#c1a85a] transition-all duration-200 text-sm sm:text-base',
              loading
                ? 'opacity-75 cursor-not-allowed'
                : 'hover:bg-[#a89248] hover:shadow-lg transform hover:-translate-y-0.5'
            ]"
            :disabled="loading"
          >
            <!-- Spinner de loading -->
            <svg
              v-if="loading"
              class="animate-spin h-4 w-4 text-white"
              fill="none"
              viewBox="0 0 24 24"
            >
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>{{ loading ? 'Entrando...' : 'Entrar' }}</span>
          </button>

          <!-- Link Esqueci a senha -->
          <button
            type="button"
            class="text-sm text-gray-600 hover:text-[#c1a85a] underline transition-colors duration-200 text-center"
            @click="handleForgotPassword"
          >
            Esqueceu sua senha?
          </button>
        </div>
      </form>
    </div>

    <!-- Rodapé -->
    <div class="mt-4 sm:mt-8 text-center px-4">
      <div class="text-xs sm:text-sm text-gray-600">
        © {{ currentYear }} Polícia Civil da Paraíba - Todos os direitos reservados
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

// Composables
const router = useRouter()

// Estado reativo do formulário
const form = reactive({
  matricula: '',
  password: '',
  remember: false
})

// Estados de controle
const loading = ref(false)
const errors = ref({})
const status = ref('')
const showPassword = ref(false)
const capsLockOn = ref(false)
const passwordInput = ref(null)

// Computed
const currentYear = computed(() => new Date().getFullYear())

// Configurar token CSRF para Axios
const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token
}

// Função para detectar Caps Lock
const checkCapsLock = (event) => {
  if (event.getModifierState) {
    capsLockOn.value = event.getModifierState('CapsLock')
  }
}

// Event listener para Caps Lock
const handlePasswordFieldEvents = (event) => {
  switch (event.type) {
    case 'keydown':
    case 'keyup':
      checkCapsLock(event)
      break
    case 'focus':
      // Verifica estado inicial do Caps Lock
      if (event.getModifierState) {
        capsLockOn.value = event.getModifierState('CapsLock')
      }
      break
    case 'blur':
      capsLockOn.value = false
      break
  }
}

// Lifecycle hooks
onMounted(() => {
  const passwordField = passwordInput.value
  if (passwordField) {
    // Adiciona os listeners
    ['keydown', 'keyup', 'focus', 'blur'].forEach(eventType => {
      passwordField.addEventListener(eventType, handlePasswordFieldEvents)
    })
  }
})

onUnmounted(() => {
  const passwordField = passwordInput.value
  if (passwordField) {
    // Remove todos os listeners
    ['keydown', 'keyup', 'focus', 'blur'].forEach(eventType => {
      passwordField.removeEventListener(eventType, handlePasswordFieldEvents)
    })
  }
})

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value
}

const validateForm = () => {
  const newErrors = {}

  if (!form.matricula) {
    newErrors.matricula = ['A matrícula é obrigatória']
  }

  if (!form.password) {
    newErrors.password = ['A senha é obrigatória']
  }

  errors.value = newErrors
  return Object.keys(newErrors).length === 0
}

// Submeter o formulário
const handleSubmit = async () => {
  if (!validateForm()) return

  loading.value = true
  errors.value = {}
  status.value = ''

  try {
    // Chamada para a API de login
    const response = await axios.post('/login', {
      matricula: form.matricula,
      password: form.password,
      remember: form.remember
    })

    /* status.value = 'Login realizado com sucesso!' */

    // Login bem sucedido, redirecionar para Home do usuário
    setTimeout(() => {
      window.location.href = '/'
    }, 1000)

  } catch (error) {
    console.error('Erro no login:', error)

    // Limpar o campo senha quando há erro de autenticação
    form.password = ''

    if (error.response) {
      // Erros de validação do servidor
      if (error.response.status === 422 && error.response.data.errors) {
        errors.value = error.response.data.errors
      } else if (error.response.status === 401) {
        errors.value = { general: ['Essas credenciais não constam em nossos registros.'] }
      } else {
        errors.value = { general: ['Erro interno do servidor. Tente novamente.'] }
      }
    } else {
      // Erro de rede ou conexão
      errors.value = { general: ['Erro de conexão. Verifique sua internet e tente novamente.'] }
    }

    setTimeout(() => {
      if (passwordInput.value) {
        passwordInput.value.focus()
      }
    }, 100)

  } finally {
    loading.value = false
  }
}

const handleForgotPassword = () => {
  // Implementar lógica de esqueci minha senha
  alert('Desenvolver funcionalidade de recuperação de senha')
}
</script>

<style scoped>
/* Animação de loading */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

/* Efeitos de hover */
button, a {
  transition: all 0.2s ease-in-out;
}

/* Visual para campos do formulário */
input:focus {
  outline: none;
  box-shadow: 0 0 0 2px rgba(193, 168, 90, 0.25);
}

/* Estilos para o autocomplete */
.matricula-input {
  background-color: white !important;
  color: #374151 !important;
}

/* dropdown de autocomplete do navegador */
.matricula-input::-webkit-textfield-decoration-container,
.matricula-input::-webkit-contacts-auto-fill-button,
.matricula-input::-webkit-credentials-auto-fill-button {
  visibility: hidden;
  pointer-events: none;
  position: absolute;
  right: 0;
}

/* Estilos para autocompletar */
.matricula-input:-webkit-autofill,
.matricula-input:-webkit-autofill:hover,
.matricula-input:-webkit-autofill:focus,
.matricula-input:-webkit-autofill:active {
  -webkit-box-shadow: 0 0 0 30px white inset !important;
  -webkit-text-fill-color: #374151 !important;
  background-color: white !important;
  color: #374151 !important;
}

/* Estilos para dropdown nativo de autocomplete */
.matricula-input::-webkit-list-button {
  color: #374151 !important;
  background-color: white !important;
}

/* Para Firefox */
.matricula-input:-moz-autofill {
  background-color: white !important;
  color: #374151 !important;
}

/* cores claras no dropdown */
input[list] {
  background-color: white !important;
  color: #374151 !important;
}

/* Estilos para datalist options */
datalist {
  background-color: white !important;
  color: #374151 !important;
}

datalist option {
  background-color: white !important;
  color: #374151 !important;
  padding: 8px 12px;
}

datalist option:hover {
  background-color: #f3f4f6 !important;
  color: #374151 !important;
}

/* Responsividade */
@media (max-width: 480px) {
  .max-w-sm {
    max-width: 95%;
  }
}

/* Acessibilidade */
@media (prefers-reduced-motion: reduce) {
  button,
  a {
    transition-duration: 0.01ms !important;
  }

  .animate-spin {
    animation: none;
  }
}

/* tema claro para autocomplete em modo escuro */
@media (prefers-color-scheme: dark) {
  .matricula-input {
    color-scheme: light !important;
    background-color: white !important;
    color: #374151 !important;
  }

  .matricula-input::-webkit-textfield-decoration-container {
    color-scheme: light !important;
  }
}
</style>
