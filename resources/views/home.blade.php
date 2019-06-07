@extends('layouts.app')

@section('content')
    <layout>
        <template slot="north">
            <topbar>
                <template slot="logo">
                    <a class="navbar-brand" href="/home">{{config('app.name')}}</a>
                </template>
                <template slot="right">
                    <avatar style="font-size: 2em"></avatar>
                </template>
            </topbar>
        </template>
        <template slot="west">
            <list v-slot="{item, control, level}" style="width:320px"
                :value="menus">
                <a href="javascript:void(0)" :class="level"
                    class="list-group-item list-group-item-action list-group-item-primary"
                    @click="control.toggle(me)">
                    <i v-if="item.icon" :class="item.icon"></i>
                    @{{item.name}}
                </a>
            </list>
        </template>
        <router-view></router-view>
    </layout>
@endsection
