<script setup>
import { useTheme } from 'vuetify'
import { hexToRgb } from '@/others/utils'

const { global } = useTheme()
</script>

<template>
  <VApp :style="`--v-global-theme-primary: ${hexToRgb(global.current.value.colors.primary)}`">
    <RouterView />
  </VApp>
</template>
