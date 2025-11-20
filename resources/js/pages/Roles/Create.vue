<script setup lang="ts">
import { computed, ref } from 'vue'
import Layout from '@/layouts/AppLayout.vue'
import { Head, useForm, Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Checkbox } from '@/components/ui/checkbox'
import { ArrowLeft, Save, Loader2, ShieldPlus, ShieldOff } from 'lucide-vue-next'

const props = defineProps<{
  permissions: { id: number; name: string }[]
}>()

const form = useForm({
  name: '',
  permissions: [] as number[],
})

const permissionSearch = ref('')

function submit() {
  form.post('/roles')
}


function formatPermissionName(name: string): string {
  return name
    .split('_')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ')
}

function togglePermission(permissionId: number, checked: boolean) {
  if (checked) {
    if (!form.permissions.includes(permissionId)) {
      form.permissions = [...form.permissions, permissionId]
    }
  } else {
    form.permissions = form.permissions.filter(id => id !== permissionId)
  }
}

function permissionMatchesSearch(permission: { id: number; name: string }) {
  const term = permissionSearch.value.trim().toLowerCase()
  if (!term) return true

  return permission.name.toLowerCase().includes(term)
}

const visiblePermissionCount = computed(() =>
  props.permissions.filter(permissionMatchesSearch).length
)
</script>

<template>
  <Layout>
    <Head title="Create Role" />
    <div class="container mx-auto px-4 py-8 max-w-4xl">
      <!-- Header with Back Button -->
      <div class="mb-8">
        <Button variant="ghost" class="px-0 mb-4 -ml-2" asChild>
          <Link href="/roles" class="flex items-center text-sm group">
            <ArrowLeft class="h-4 w-4 mr-2 transition-transform group-hover:-translate-x-1" />
            Back to Roles
          </Link>
        </Button>
        <div>
          <h1 class="text-3xl font-bold tracking-tight text-foreground">Create New Role</h1>
          <p class="text-muted-foreground mt-1">Define a new role and assign permissions</p>
        </div>
      </div>

      <!-- Main Form Card -->
      <Card class="overflow-hidden">
        <form @submit.prevent="submit">
          <CardHeader class="border-b bg-muted/10">
            <CardTitle class="flex items-center gap-2">
              <ShieldPlus class="h-5 w-5 text-primary" />
              Role Information
            </CardTitle>
            <CardDescription>Enter the details for the new role</CardDescription>
          </CardHeader>
          
          <CardContent class="pt-6 pb-8 space-y-8">
            <!-- Role Name Input -->
            <div class="space-y-2">
              <div class="flex items-center justify-between">
                <Label for="name" class="text-sm font-medium">Role Name</Label>
                <span class="text-xs text-muted-foreground">Required</span>
              </div>
              <Input
                id="name"
                v-model="form.name"
                placeholder="e.g. Content Manager, Support Agent"
                class="h-11 text-base"
                :disabled="form.processing"
                required
              />
              <p class="text-sm text-muted-foreground">
                A clear, descriptive name for this role
              </p>
            </div>

            <!-- Permissions Section -->
            <div class="space-y-3">
              <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div class="space-y-0.5">
                  <Label class="text-sm font-medium">Permissions</Label>
                  <p class="text-sm text-muted-foreground">
                    Select the permissions to assign to this role
                  </p>
                </div>
                <div class="w-full sm:w-64">
                  <Input
                    v-model="permissionSearch"
                    type="text"
                    placeholder="Search permissions..."
                    class="h-9 text-sm"
                    @keydown.enter.prevent
                  />
                </div>
              </div>

              <div v-if="visiblePermissionCount > 0" class="rounded-lg border bg-background/40">
                <div class="relative max-h-[360px] overflow-y-auto px-4 py-3">
                  <div class="grid gap-2.5 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <div 
                      v-for="permission in props.permissions" 
                      :key="permission.id"
                      v-show="permissionMatchesSearch(permission)"
                      class="flex items-center space-x-3 px-2 py-2 rounded-md hover:bg-muted/30 transition-colors"
                    >
                      <Checkbox
                        :id="'perm-' + permission.id"
                        :checked="form.permissions.includes(permission.id)"
                        @update:checked="(checked: boolean) => togglePermission(permission.id, checked)"
                        class="h-5 w-5 rounded-md border-2 border-muted-foreground/30"
                      />
                      <Label 
                        :for="'perm-' + permission.id" 
                        class="text-sm font-normal leading-tight cursor-pointer select-none"
                      >
                        {{ formatPermissionName(permission.name) }}
                      </Label>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else class="rounded-lg border-2 border-dashed p-8 text-center">
                <ShieldOff class="mx-auto h-12 w-12 text-muted-foreground/40 mb-3" />
                <h4 class="text-sm font-medium text-muted-foreground">No permissions available</h4>
                <p class="text-xs text-muted-foreground mt-1">
                  You need to create permissions before assigning them to roles.
                </p>
              </div>
            </div>
          </CardContent>

          <CardFooter class="flex justify-between border-t bg-muted/5 px-6 py-5">
            <Button 
              type="button" 
              variant="outline" 
              asChild
              :disabled="form.processing"
            >
              <Link href="/roles">Cancel</Link>
            </Button>
            <Button 
              type="submit" 
              :disabled="form.processing || !form.name"
              class="min-w-[120px]"
            >
              <Loader2 v-if="form.processing" class="h-4 w-4 mr-2 animate-spin" />
              <Save v-else class="h-4 w-4 mr-2" />
              {{ form.processing ? 'Creating...' : 'Create Role' }}
            </Button>
          </CardFooter>
        </form>
      </Card>
    </div>
  </Layout>
</template>
