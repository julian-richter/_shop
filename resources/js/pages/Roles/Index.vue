<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Plus, Pencil, Shield, ShieldOff } from 'lucide-vue-next'

defineProps<{
  roles: Array<{
    id: number
    name: string
    permissions: Array<{ id: number; name: string }>
  }>
}>()
</script>

<template>
  <Layout>
    <Head title="Roles" />
    <div class="container mx-auto px-4 py-8">
      <!-- Header Section -->
      <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div>
            <h1 class="text-3xl font-bold tracking-tight text-foreground">Role Management</h1>
            <p class="text-muted-foreground mt-1">Manage user roles and their permissions</p>
          </div>
          <Button as-child class="w-full sm:w-auto">
            <Link href="/roles/create" class="flex items-center justify-center">
              <Plus class="h-4 w-4 mr-2" />
              Create New Role
            </Link>
          </Button>
        </div>
      </div>

      <!-- Roles Grid -->
      <div v-if="roles.length > 0" class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        <Card v-for="role in roles" 
              :key="role.id" 
              class="hover:shadow-lg transition-all duration-200 hover:border-primary/20 group overflow-hidden relative">
          <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          <CardHeader class="relative z-10">
            <div class="flex justify-between items-start">
              <div>
                <CardTitle class="text-xl flex items-center gap-2">
                  <Shield class="h-5 w-5 text-primary" />
                  {{ role.name }}
                </CardTitle>
                <CardDescription class="mt-1.5">
                  {{ role.permissions.length }} permission{{ role.permissions.length !== 1 ? 's' : '' }} assigned
                </CardDescription>
              </div>
              <Badge variant="outline" class="ml-2" :class="{
                'border-green-200 text-green-800 dark:border-green-900/50 dark:text-green-400': role.name === 'admin',
                'border-blue-200 text-blue-800 dark:border-blue-900/50 dark:text-blue-400': role.name !== 'admin'
              }">
                {{ role.name === 'admin' ? 'Admin' : 'Standard' }}
              </Badge>
            </div>
          </CardHeader>
          <CardContent class="relative z-10 pt-0">
            <div v-if="role.permissions.length > 0" class="space-y-3">
              <div class="flex flex-wrap gap-2">
                <Badge v-for="perm in role.permissions.slice(0, 4)" 
                      :key="perm.id" 
                      variant="secondary" 
                      class="font-normal rounded-full bg-secondary/50 backdrop-blur-sm">
                  {{ perm.name }}
                </Badge>
                <Badge v-if="role.permissions.length > 4" 
                      variant="outline" 
                      class="font-normal rounded-full">
                  +{{ role.permissions.length - 4 }} more
                </Badge>
              </div>
            </div>
            <div v-else class="rounded-lg border border-dashed p-4 text-center">
              <p class="text-sm text-muted-foreground">No permissions assigned yet</p>
            </div>
          </CardContent>
          <CardFooter class="relative z-10 flex justify-end gap-2 pt-0">
            <Button variant="outline" size="sm" as-child class="group-hover:bg-background/80 backdrop-blur-sm">
              <Link :href="`/roles/${role.id}/edit`" class="flex items-center">
                <Pencil class="h-3.5 w-3.5 mr-2" />
                Edit
              </Link>
            </Button>
          </CardFooter>
        </Card>
      </div>

      <!-- Empty State -->
      <div v-else class="flex flex-col items-center justify-center py-16 rounded-2xl border-2 border-dashed border-muted-foreground/20">
        <div class="w-20 h-20 mb-6 text-muted-foreground/40">
          <ShieldOff class="w-full h-full" />
        </div>
        <h3 class="text-xl font-medium mb-2 text-foreground">No roles found</h3>
        <p class="text-muted-foreground mb-6 max-w-md text-center">
          Get started by creating your first role and assigning permissions to manage user access.
        </p>
        <Button as-child>
          <Link href="/roles/create" class="flex items-center">
            <Plus class="h-4 w-4 mr-2" />
            Create Role
          </Link>
        </Button>
      </div>
    </div>
  </Layout>
</template>
