import _ from 'lodash'
import moment from 'moment'

import API from '../api'

// mutation constants (move to other file later?)
const SET_EVENT = 'SET_EVENT'

export default {
    namespaced: true,
    state: {
        event: {},
    },
    getters: {
        // Convert EventDay objects to full-calendar readable format
        fullCalendarEvents(state) {
            const event = state.event
            const eventDays = state.event.event_days || []
            return eventDays.map(({ date }) => {
                return {
                    title: event.title,
                    start: date
                }
            })
        },
        // Convert EventDay objects to ListCalendar readable format
        listCalendarEvents(state) {
            const event = state.event
            const eventDays = state.event.event_days || []
            return eventDays.map(({ date }) => {
                return {
                    title: event.title,
                    date
                }
            })
        },
    },
    actions: {
        async getEvents({ commit }, event) {
            const { data } = await API.get(`/events`)
            commit(SET_EVENT, data)
            return data
        },
        async updateEvent({ commit }, event) {
            const { data } = await API.put(`/events/${event.id}`, event)
            const updatedEvent = data
            commit(SET_EVENT, updatedEvent)
            return updatedEvent
        },
        async createEvent({ commit }, event) {
            const { data } = await API.post('/events', event)
            const newEvent = data
            commit(SET_EVENT, newEvent)
            return newEvent
        }
    },
    mutations: {
        [SET_EVENT] (state, event){
            state.event = event
        },
    }
}
