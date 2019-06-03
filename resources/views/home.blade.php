@extends('layouts.app')

@section('content')
    <layout>
        <template slot="north">
            <topbar>
                <template slot="logo">
                    <a class="navbar-brand" href="/">{{config('app.name')}}</a>
                </template>
                <template slot="right">
                    <avatar style="font-size: 2em"></avatar>
                </template>
            </topbar>
        </template>
        <template slot="west">
            <list v-slot="{item, control}" style="width:320px"
                :value="[{id:1,parent:0,name:'Dashboard'},{id:2,parent:1,name:'Admin'}]">
                <a href="javascript:void(0)" @click="control.toggle()">@{{item.name}}</a>
            </list>
        </template>
        <router-view></router-view>
    </layout>
@endsection
