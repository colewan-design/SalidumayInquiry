<template>
  <div class="min-h-screen bg-white font-inter flex flex-col">

    <!-- Header -->
    <header class="flex items-center justify-between px-8 py-5 border-b border-gray-100">
      <a href="https://salidumay.com" class="flex items-center gap-2">
        <span class="text-xl font-bold text-gray-900 tracking-tight">Salidumay</span>
      </a>
      <a href="https://salidumay.com" class="text-sm text-gray-500 hover:text-gray-800 transition-colors">
        ← Go Back
      </a>
    </header>

    <!-- Body -->
    <main class="flex flex-1 flex-col lg:flex-row">

      <!-- Left: testimonials + logos -->
      <div class="lg:w-1/2 bg-gray-50 flex flex-col justify-between px-10 py-12 lg:px-16">

        <!-- Testimonials -->
        <div class="flex-1 flex flex-col justify-center max-w-md mx-auto w-full">
          <div class="relative min-h-55">
            <transition-group name="slide" tag="div">
              <div
                v-for="(t, i) in testimonials"
                :key="i"
                v-show="activeTestimonial === i"
                class="absolute inset-0"
              >
                <img :src="t.avatar" :alt="t.name"
                     class="w-16 h-16 rounded-full object-cover mx-auto mb-5 shadow-md">
                <blockquote class="text-gray-700 text-center text-lg leading-relaxed italic mb-5">
                  "{{ t.quote }}"
                </blockquote>
                <div class="text-center">
                  <div class="w-8 h-px bg-gray-400 mx-auto mb-3"></div>
                  <p class="font-semibold text-gray-900 text-sm">{{ t.name }}</p>
                  <p class="text-gray-500 text-xs">{{ t.company }}</p>
                </div>
              </div>
            </transition-group>
          </div>

          <!-- Dots -->
          <div class="flex justify-center gap-2 mt-8">
            <button
              v-for="(_, i) in testimonials"
              :key="i"
              @click="activeTestimonial = i"
              class="w-2.5 h-2.5 rounded-full transition-colors"
              :class="activeTestimonial === i ? 'bg-blue-600' : 'bg-gray-300 hover:bg-gray-400'"
            />
          </div>
        </div>

        <!-- Client logos -->
        <div class="mt-12">
          <p class="text-xs text-gray-400 uppercase tracking-widest text-center mb-6">Trusted by</p>
          <div class="grid grid-cols-3 gap-4">
            <div
              v-for="client in clients"
              :key="client.name"
              class="flex items-center justify-center bg-white rounded-lg py-3 px-4 shadow-sm"
            >
              <span class="text-xs font-semibold text-gray-500 tracking-wide">{{ client.name }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right: form -->
      <div class="lg:w-1/2 flex flex-col justify-center px-8 py-12 lg:px-16">
        <div class="max-w-md w-full mx-auto">

          <div class="mb-2 text-right">
            <span class="text-xs text-gray-400">Free trial for 15 days* · Secured by NDA</span>
          </div>

          <h1 class="text-3xl font-bold text-gray-900 mb-8 leading-snug">
            Ready to work with us?<br>Tell us more.
          </h1>

          <!-- Success banner -->
          <div v-if="$page.props.flash?.success"
               class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
            {{ $page.props.flash.success }}
          </div>

          <form @submit.prevent="submit" class="space-y-5">

            <!-- Name -->
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">
                <span class="text-red-500">*</span> Name
              </label>
              <div class="flex gap-3">
                <div class="flex-1">
                  <input v-model="form.first_name" type="text" placeholder="First"
                         class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                         :class="{ 'border-red-400': errors.first_name }">
                  <p v-if="errors.first_name" class="text-red-500 text-xs mt-1">{{ errors.first_name }}</p>
                </div>
                <div class="flex-1">
                  <input v-model="form.last_name" type="text" placeholder="Last"
                         class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                         :class="{ 'border-red-400': errors.last_name }">
                  <p v-if="errors.last_name" class="text-red-500 text-xs mt-1">{{ errors.last_name }}</p>
                </div>
              </div>
            </div>

            <!-- Topic -->
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">
                <span class="text-red-500">*</span> Select a topic
              </label>
              <select v-model="form.topic"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      :class="{ 'border-red-400': errors.topic, 'text-gray-400': !form.topic }">
                <option value="" disabled>Select</option>
                <option v-for="t in topics" :key="t" :value="t">{{ t }}</option>
              </select>
              <p v-if="errors.topic" class="text-red-500 text-xs mt-1">{{ errors.topic }}</p>
            </div>

            <!-- Email -->
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">
                <span class="text-red-500">*</span> Email
              </label>
              <input v-model="form.email" type="email" placeholder="you@example.com"
                     class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                     :class="{ 'border-red-400': errors.email }">
              <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
            </div>

            <!-- Phone -->
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">
                <span class="text-red-500">*</span> Mobile phone
              </label>
              <div class="flex gap-2">
                <select v-model="form.country_code"
                        class="border border-gray-300 rounded-lg px-2 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-28">
                  <option v-for="c in countryCodes" :key="c.code" :value="c.code">
                    {{ c.flag }} {{ c.code }}
                  </option>
                </select>
                <input v-model="form.phone_number" type="tel" placeholder="9XX XXX XXXX"
                       class="flex-1 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       :class="{ 'border-red-400': errors.phone }">
              </div>
              <p v-if="errors.phone" class="text-red-500 text-xs mt-1">{{ errors.phone }}</p>
            </div>

            <!-- Company -->
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Company name</label>
              <input v-model="form.company" type="text" placeholder="Optional"
                     class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Brief -->
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Brief about the project</label>
              <textarea v-model="form.brief" rows="4" placeholder="Tell us what you have in mind…"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-between pt-1">
              <button type="submit"
                      :disabled="processing"
                      class="bg-blue-600 hover:bg-blue-700 disabled:opacity-60 text-white font-semibold text-sm px-8 py-3 rounded-lg transition-colors shadow-sm">
                {{ processing ? 'Sending…' : 'Get Started' }}
              </button>
              <p class="text-xs text-gray-400 text-right leading-tight">
                100% Secure.<br>Zero Spam.
              </p>
            </div>

          </form>
        </div>
      </div>

    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-100 px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-2">
      <p class="text-xs text-gray-400">© {{ new Date().getFullYear() }} Salidumay. All rights reserved.</p>
      <div class="flex items-center gap-4">
        <a href="https://salidumay.com" class="text-xs text-gray-400 hover:text-gray-700 transition-colors">salidumay.com</a>
        <a href="https://komyuter.com" class="text-xs text-gray-400 hover:text-gray-700 transition-colors">komyuter.com</a>
        <a href="https://eishipartners.com" class="text-xs text-gray-400 hover:text-gray-700 transition-colors">eishipartners.com</a>
      </div>
    </footer>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

// Testimonial carousel
const activeTestimonial = ref(0);

const testimonials = [
  {
    name: 'Christian Colewan',
    company: 'Salidumay / GPX2Video',
    quote: 'Built tools that thousands of cyclists and commuters rely on every day. The attention to detail is unmatched.',
    avatar: 'https://ui-avatars.com/api/?name=Christian+Colewan&background=3B82F6&color=fff&size=128',
  },
  {
    name: 'Eishi Partners',
    company: 'eishipartners.com',
    quote: 'A seamless experience from idea to deployment. Our partnership portal was delivered ahead of schedule.',
    avatar: 'https://ui-avatars.com/api/?name=Eishi+Partners&background=6366F1&color=fff&size=128',
  },
  {
    name: 'Komyuter Team',
    company: 'komyuter.com',
    quote: 'Transformed how Filipino commuters navigate the city. The app is fast, beautiful, and incredibly reliable.',
    avatar: 'https://ui-avatars.com/api/?name=Komyuter+Team&background=10B981&color=fff&size=128',
  },
];

// Auto-advance carousel
import { onMounted, onUnmounted } from 'vue';
let timer;
onMounted(() => {
  timer = setInterval(() => {
    activeTestimonial.value = (activeTestimonial.value + 1) % testimonials.length;
  }, 5000);
});
onUnmounted(() => clearInterval(timer));

// Clients / trusted by
const clients = [
  { name: 'salidumay.com' },
  { name: 'komyuter.com' },
  { name: 'eishipartners.com' },
  { name: 'GPX2Video' },
  { name: 'BSU CBOO' },
  { name: 'Philippines' },
];

// Topics
const topics = [
  'Website Development',
  'Mobile App Development',
  'GPS & Video Tools',
  'Business Partnership',
  'API Integration',
  'UI/UX Design',
  'General Inquiry',
];

// Country codes
const countryCodes = [
  { flag: '🇵🇭', code: '+63' },
  { flag: '🇺🇸', code: '+1' },
  { flag: '🇬🇧', code: '+44' },
  { flag: '🇦🇺', code: '+61' },
  { flag: '🇨🇦', code: '+1' },
  { flag: '🇸🇬', code: '+65' },
  { flag: '🇯🇵', code: '+81' },
  { flag: '🇦🇪', code: '+971' },
];

// Form
const form = useForm({
  first_name: '',
  last_name: '',
  topic: '',
  email: '',
  country_code: '+63',
  phone_number: '',
  company: '',
  brief: '',
});

const processing = computed(() => form.processing);
const errors = computed(() => form.errors);

function submit() {
  form.transform((data) => ({
    ...data,
    phone: `${data.country_code} ${data.phone_number}`,
  })).post('/', {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  });
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.font-inter { font-family: 'Inter', sans-serif; }

.slide-enter-active,
.slide-leave-active { transition: opacity 0.4s ease, transform 0.4s ease; }
.slide-enter-from  { opacity: 0; transform: translateX(20px); }
.slide-leave-to    { opacity: 0; transform: translateX(-20px); }
</style>
