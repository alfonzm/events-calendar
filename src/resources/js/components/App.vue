<template lang="pug">
    div
        notifications.m-2(group='all' position='top right')
        div(class='p-2 sm:p-10 bg-gray-200')
            .bg-white.rounded.shadow-md
                section.px-5.pt-6.pb-2.border-b
                    .flex.items-center.justify-between.mb-3
                        h1.text-2xl.font-bold Calendar
                        button(class='bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none' @click='isListView = !isListView' type='button') {{ isListView ? 'Calendar' : 'List' }} View
                div(class='lg:flex p-5')
                    section(class='w-full lg:w-1/3 mb-5 mr-10')
                        event-form(@submit='onSaveEvent' :isLoading='isLoading' :event='event')
                    section(class='w-full lg:w-2/3')
                        event-calendar(:type="isListView ? 'list' : 'full'")
</template>

<script>

import _ from 'lodash'
import { mapActions, mapState } from 'vuex'

import EventCalendar from './EventCalendar'
import EventForm from './EventForm'

export default {
    name: 'App',
    components: {
        EventCalendar,
        EventForm,
    },
    data() {
        return {
            isListView: true,
            isLoading: false
        }
    },
    computed: {
        ...mapState('events', {
            event: state => state.event,
        }),
    },
    methods: {
        ...mapActions('events', [
            'createEvent',
            'updateEvent',
        ]),
        showErrorNotification(text) {
            this.$notify({
                title: text,
                group: 'all',
                type: 'error',
            })
        },
        showSuccessNotification(text) {
            this.$notify({
                title: text,
                group: 'all',
                type: 'success',
            })
        },
        async onSaveEvent(event) {
            try {
                this.isLoading = true

                if (this.event.id) {
                    await this.updateEvent({
                        id: this.event.id,
                        ...event
                    })
                    this.showSuccessNotification('Event successfully updated!')
                } else {
                    await this.createEvent(event)
                    this.showSuccessNotification('Event successfully added!')
                }
            } catch({ message, errors }) {
                const errorMessages = _.chain(errors)
                    .toArray()
                    .flatten()
                    .value()

                errorMessages.forEach((errorMessage) => {
                    this.showErrorNotification(errorMessage)
                })
            } finally {
                // simulate API loading...
                setTimeout(() =>{
                    this.isLoading = false
                }, 200)
            }
        }
    }
}
</script>

<style>

</style>
