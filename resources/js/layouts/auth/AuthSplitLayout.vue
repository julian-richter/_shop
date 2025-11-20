<script setup lang="ts">
import { ref } from 'vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';
import { Link } from '@inertiajs/vue3';
import { 
    Code, 
    Smartphone, 
    Server, 
    Zap
} from 'lucide-vue-next';

const appName = import.meta.env.VITE_APP_NAME;

defineProps<{
    title?: string;
    description?: string;
}>();

const features = [
    {
        icon: Code,
        title: 'Custom Software',
        description: 'Tailored solutions for your unique needs'
    },
    {
        icon: Smartphone,
        title: 'Mobile Apps',
        description: 'iOS & Android development'
    },
    {
        icon: Server,
        title: 'Hosting',
        description: 'Reliable cloud solutions'
    },
    {
        icon: Zap,
        title: 'Automation',
        description: 'Streamline your workflow'
    }
];

const steps = [
    {
        title: 'Request a Quote',
        description: 'Tell us about your project needs'
    },
    {
        title: 'Discuss Requirements',
        description: 'We refine the details together'
    },
    {
        title: 'Get a Proposal',
        description: 'Receive a detailed plan and pricing'
    },
    {
        title: 'Start Building',
        description: 'We bring your vision to life'
    }
];

</script>

<template>
    <div class="relative flex h-dvh w-full overflow-hidden">
        <!-- Left Side - Content -->
        <div class="relative hidden h-full w-1/2 flex-col justify-center bg-gradient-to-br from-primary/5 to-primary/10 p-16 lg:flex">
            <!-- Main Content -->
            <div class="z-20 max-w-lg">
                <h2 class="mb-10 bg-gradient-to-r from-foreground to-foreground/80 bg-clip-text text-4xl font-bold text-transparent">
                    Transform Your Ideas Into Reality
                </h2>
                
                <p class="mb-8 text-lg text-muted-foreground">
                    Professional custom software solutions tailored to your business needs. From concept to deployment, we've got you covered.
                </p>

                <!-- Features Grid -->
                <div class="grid grid-cols-2 gap-6">
                    <div v-for="(feature, index) in features" :key="index" class="group relative overflow-hidden rounded-xl p-4 transition-all hover:bg-primary/5">
                        <div class="mb-3 flex size-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                            <component :is="feature.icon" class="size-5" />
                        </div>
                        <h3 class="mb-1 font-medium text-foreground">{{ feature.title }}</h3>
                        <p class="text-sm text-muted-foreground">{{ feature.description }}</p>
                    </div>
                </div>

                <!-- How It Works -->
                <div class="mt-12">
                    <h3 class="mb-8 text-xl font-semibold text-foreground">How It Works</h3>
                    <div class="relative">
                        <div class="absolute left-[18px] top-0 h-full w-px bg-border"></div>
                        <div class="space-y-8">
                            <div v-for="(step, index) in steps" :key="index" class="relative flex items-start">
                                <div class="absolute left-0 top-0 flex h-9 w-9 items-center justify-center rounded-full border-2 border-primary bg-background text-sm font-medium text-foreground">
                                    {{ index + 1 }}
                                </div>
                                <div class="ml-12">
                                    <h4 class="text-base font-medium text-foreground">
                                        {{ step.title }}
                                    </h4>
                                    <p class="mt-1 text-sm text-muted-foreground">
                                        {{ step.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Removed bottom links from left side -->

            <!-- Decorative Elements -->
            <div class="pointer-events-none absolute -right-32 -top-32 h-64 w-64 rounded-full bg-primary/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-32 h-64 w-64 rounded-full bg-primary/5 blur-3xl"></div>
        </div>

        <!-- Right Side - Form -->
        <div class="flex h-full w-full flex-col overflow-y-auto bg-background p-8 lg:w-1/2">
            <!-- Logo - Moved to top right -->
            <div class="mb-12 flex justify-end">
                <Link :href="home()" class="z-20 flex items-center space-x-3">
                    <AppLogoIcon class="size-10 text-primary" />
                    <span class="bg-gradient-to-r from-primary to-primary/80 bg-clip-text text-2xl font-bold text-transparent">{{ appName }}</span>
                </Link>
            </div>
            
            <!-- Form Content -->
            <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                <div class="space-y-8">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold tracking-tight text-foreground" v-if="title">
                            {{ title }}
                        </h1>
                        <p class="mt-3 text-muted-foreground" v-if="description">
                            {{ description }}
                        </p>
                    </div>
                    <div class="space-y-6">
                        <slot />
                    </div>
                    
                    <!-- Bottom Links - Moved to bottom of form -->
                    <div class="mt-12 flex flex-col items-center justify-between space-y-4 text-center text-sm text-muted-foreground sm:flex-row sm:space-y-0">
                        <span>© {{ new Date().getFullYear() }} {{ appName }}. All rights reserved.</span>
                        <div class="flex space-x-4">
                            <a href="#" class="hover:text-foreground">Terms</a>
                            <a href="#" class="hover:text-foreground">Privacy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
