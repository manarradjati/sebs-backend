<script setup>
import { computed } from 'vue'

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  image: {
    type: String,
    required: true,
  },
  stats: {
    type: String,
    required: true,
  },
  change: {
    type: Number,
    required: true,
  },
})

const isPositive = computed(() => props.change, () => Math.sign(props.change) === 1)
</script>

<template>
  <VCard>
    <VCardText class="d-flex align-center pb-4">
      <img
        width="42"
        :src="props.image"
        alt="image"
      >

      <VSpacer />

      <MoreBtn
        size="x-small"
        class="me-n3 mt-n4"
      />
    </VCardText>

    <VCardText>
      <p class="mb-1">
        {{ props.title }}
      </p>
      <h5 class="text-h5 text-no-wrap mb-3">
        {{ props.stats }}
      </h5>
      <span
        :class="isPositive ? 'text-success' : 'text-error'"
        class="d-flex align-center gap-1 text-sm"
      >
        <VIcon
          size="18"
          :icon="isPositive ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt'"
        />
        {{ isPositive ? Math.abs(props.change) : props.change }}%
      </span>
    </VCardText>
  </VCard>
</template>
