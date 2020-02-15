<template lang="pug">
    section
        full-calendar(
            v-if=`type == 'full'`
            defaultView='dayGridMonth'
            :plugins='calendarPlugins'
            :events='fullCalendarEvents'
            @eventClick='onClickEventDay'
            )
        list-calendar(
            v-if=`type === 'list'`
            :events='listCalendarEvents'
            )
</template>

<script>

import { mapGetters } from 'vuex'
import moment from 'moment'
import FullCalendar from '@fullcalendar/vue'
import listPlugin from '@fullcalendar/list'
import dayGridPlugin from '@fullcalendar/daygrid'

import ListCalendar from './ListCalendar'

export default {
    props: [
        'type'
    ],
    components: {
        FullCalendar,
        ListCalendar,
    },
    computed: {
        ...mapGetters('events', {
            fullCalendarEvents: 'fullCalendarEvents',
            listCalendarEvents: 'listCalendarEvents',
        })
    },
    data() {
        return {
            calendarPlugins: [listPlugin, dayGridPlugin],
        }
    },
    methods: {
        onClickEventDay ({ event }) {
            // print event title...
        },
        submitForm(e) {
            e.preventDefault()
            this.$emit('submit', {
                title: this.title,
                days: [...this.days],
                start_date: moment(this.date_range.start).format('YYYY-MM-DD'),
                end_date: moment(this.date_range.end).format('YYYY-MM-DD'),
            })
        }
    }
}
</script>

<style>

</style>
