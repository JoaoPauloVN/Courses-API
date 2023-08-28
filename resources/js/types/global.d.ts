import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import ziggyRoute, { Config as ZiggyConfig } from 'ziggy-js';
import { PageProps as AppPageProps } from './';

declare global {
    interface Window {
        axios: AxiosInstance;
    }
    
    interface Params {
        name: string;
        value: string|number;
        types: Array<String>;
        field: string;
        input: string;
        options: Array<String>;
        find: function;
    }

    interface Route {
        api_url: string;
        bodyParams: Params;
        method: string;
        name: string;
        pathParams: Params;
        queryParams: Params;
        url: string;
    }

    interface Routes {
        name: string;
        routes: Array<Object>;
    }



    var route: typeof ziggyRoute;
    var Ziggy: ZiggyConfig;
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}

export { Params, Route, Routes }
