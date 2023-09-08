import { usePage } from "@inertiajs/vue3"
import { defineStore } from "pinia"
import { computed, ref } from "vue";

export const useRoutesStore = defineStore('routes', () => {
    const page = usePage();
    const loading = ref(false);
    const api_token = ref("");

    function formatRoute(url, name, method, api, pathParams, query, body) {
        let data = page.props.ziggy

        url = data.url + '/' + data.routes[url].uri;
        let api_url = data.url + '/' + data.routes[api].uri;

        return {
            url: url,
            name: name,
            method: method.toUpperCase(),
            api_url: api_url,
            pathParams: pathParams,
            queryParams: query,
            bodyParams: body
        };
    }

    const routes = [
        {
            name: 'getting start',
            routes: [
                {
                    url: '/',
                    name: 'Welcome',
                    method: 'GET',
                }
            ]
        },
        {
            name: 'Account',
            routes: [
                formatRoute('auth.register', 'Register', 'post', 'api.auth.register', null, null, [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required']
                    },
                    {
                        name: 'email',
                        value: '',
                        types: ['email', 'required']
                    },
                    {
                        name: 'password',
                        value: '',
                        types: ['password', 'required']
                    }
                ]),
                formatRoute('auth.login', 'Login', 'post', 'api.auth.login', null, null, [
                    {
                        name: 'email',
                        value: '',
                        types: ['email', 'required']
                    },
                    {
                        name: 'password',
                        value: '',
                        types: ['string', 'required']
                    }
                ]),
            ]
        },
        {
            name: 'instructors',
            routes: [
                formatRoute('instructors.details', 'Details', 'get', 'api.instructor.show', [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required'],
                        field: 'instructor'
                    }
                ])
            ]
        },
        {
            name: "courses",
            routes: [
                formatRoute('courses.list', 'List', 'get', 'api.courses.index', null, [
                    {
                        name: 'page',
                        value: 1,
                        types: ['int']
                    }
                ]),
                formatRoute('courses.details', 'Details', 'get', 'api.courses.show', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    }
                ]),
                formatRoute('courses.store', 'Create', 'post', 'api.courses.store', null, null, [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required']
                    },
                    {
                        name: 'description',
                        value: '',
                        types: ['string', 'required']
                    },
                    {
                        name: 'difficulty_level',
                        value: '',
                        types: ['string', 'required'],
                        input: 'select',
                        options: ['Beginner', 'Intermediate', 'Advanced']
                    },
                    {
                        name: 'price',
                        value: '',
                        types: ['decimal', 'required']
                    },
                    {
                        name: 'category_id',
                        value: '',
                        types: ['int', 'required']
                    },
                    {
                        name: 'language_id',
                        value: '',
                        types: ['int', 'required']
                    },
                ]),
                formatRoute('courses.update', 'Update', 'put', 'api.courses.update', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    }
                ], null, [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required']
                    },
                    {
                        name: 'description',
                        value: '',
                        types: ['string', 'required']
                    },
                    {
                        name: 'difficulty_level',
                        value: '',
                        types: ['string', 'required'],
                        input: 'select',
                        options: ['Beginner', 'Intermediate', 'Advanced']
                    },
                    {
                        name: 'price',
                        value: '',
                        types: ['decimal', 'required']
                    },
                    {
                        name: 'category_id',
                        value: '',
                        types: ['int', 'required']
                    },
                    {
                        name: 'language_id',
                        value: '',
                        types: ['int', 'required']
                    },
                ]),
                formatRoute('courses.destroy', 'Delete', 'delete', 'api.courses.destroy', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    }
                ]),
                formatRoute('courses.students', 'Students', 'get', 'api.courses.users', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    }
                ]),
                formatRoute('courses.subscribe', 'Subscribe', 'post', 'api.courses.subscribe', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    },
                    {
                        name: 'user',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'user'
                    }
                ]),
                formatRoute('courses.unsubscribe', 'Unsubscribe', 'post', 'api.courses.unsubscribe', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    },
                    {
                        name: 'user',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'user'
                    }
                ]),
            ]
        },
        {
            name: "modules",
            routes: [
                // formatRoute('modules.list', 'List', 'get', 'api.courses.index', null, [
                //     {
                //         name: 'page',
                //         value: 1,
                //         types: ['int']
                //     }
                // ]),
                formatRoute('modules.store', 'Create', 'post', 'api.modules.store', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    }
                ], null, [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required']
                    },
                    {
                        name: 'description',
                        value: '',
                        types: ['string', 'required']
                    }
                ]),
                formatRoute('modules.update', 'Update', 'put', 'api.modules.update', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    },
                    {
                        name: 'module',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'module'
                    }
                ], null, [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required']
                    },
                    {
                        name: 'description',
                        value: '',
                        types: ['string', 'required']
                    }
                ]),
                formatRoute('modules.destroy', 'Delete', 'delete', 'api.modules.destroy', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    },
                    {
                        name: 'module',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'module'
                    }
                ])
            ]
        },
        {
            name: "lessons",
            routes: [
                // formatRoute('lessons.list', 'List', 'get', 'api.courses.index', null, [
                //     {
                //         name: 'page',
                //         value: 1,
                //         types: ['int']
                //     }
                // ]),
                formatRoute('lessons.store', 'Create', 'post', 'api.lessons.store', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    },
                    {
                        name: 'module',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'module'
                    }
                ], null, [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required']
                    },
                    {
                        name: 'content',
                        value: '',
                        types: ['string', 'required']
                    }
                ]),
                formatRoute('lessons.update', 'Update', 'put', 'api.lessons.update', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    },
                    {
                        name: 'module',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'module'
                    },
                    {
                        name: 'lesson',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'lesson'
                    }
                ], null, [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required']
                    },
                    {
                        name: 'content',
                        value: '',
                        types: ['string', 'required']
                    }
                ]),
                formatRoute('lessons.destroy', 'Delete', 'delete', 'api.lessons.destroy', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    },
                    {
                        name: 'module',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'module'
                    },
                    {
                        name: 'lesson',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'lesson'
                    }
                ])
            ]
        },
        {
            name: 'course categories',
            routes: [
                formatRoute('categories.list', 'List', 'get', 'api.categories.index', null, [
                    {
                        name: 'page',
                        value: 1,
                        types: ['int']
                    }
                ]),
                formatRoute('categories.store', 'Create', 'post', 'api.categories.store', null, null, [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required']
                    }
                ]),
                formatRoute('categories.update', 'Update', 'put', 'api.categories.update', [
                    {
                        name: 'id',
                        value: '',
                        types: ['int', 'required'],
                        field: 'category'
                    },
                ], null, [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required']
                    }
                ]),
                formatRoute('categories.destroy', 'Delete', 'delete', 'api.categories.destroy', [
                    {
                        name: 'id',
                        value: '',
                        types: ['int', 'required'],
                        field: 'category'
                    }
                ]),
            ]
        },
        {
            name: 'course learnings',
            routes: [
                formatRoute('learnings.store', 'Create', 'post', 'api.learnings.store', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    },
                ], null, [
                    {
                        name: 'content',
                        value: '',
                        types: ['string', 'required']
                    },
                ]),
                formatRoute('learnings.update', 'Update', 'put', 'api.learnings.update', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    },
                    {
                        name: 'learning',
                        value: '',
                        types: ['id', 'string', 'required'],
                        field: 'learning'
                    }
                ], null, [
                    {
                        name: 'content',
                        value: '',
                        types: ['string', 'required']
                    },
                ]),
                formatRoute('learnings.destroy', 'Delete', 'delete', 'api.learnings.destroy', [
                    {
                        name: 'course',
                        value: '',
                        types: ['slug', 'string', 'required'],
                        field: 'course'
                    },
                    {
                        name: 'learning',
                        value: '',
                        types: ['id', 'string', 'required'],
                        field: 'learning'
                    }
                ])
            ]
        },
        {
            name: 'skills',
            routes: [
                formatRoute('skills.list', 'List', 'get', 'api.skills.index', null, [
                    {
                        name: 'page',
                        value: 1,
                        types: ['int']
                    }
                ]),
                formatRoute('skills.store', 'Create', 'post', 'api.skills.store', null, null, [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required']
                    }
                ]),
                formatRoute('skills.update', 'Update', 'put', 'api.skills.update', [
                    {
                        name: 'id',
                        value: '',
                        types: ['int', 'required'],
                        field: 'skill'
                    }
                ], null, [
                    {
                        name: 'name',
                        value: '',
                        types: ['string', 'required']
                    }
                ]),
                formatRoute('skills.destroy', 'Delete', 'delete', 'api.skills.destroy', [
                    {
                        name: 'id',
                        value: '',
                        types: ['int', 'required'],
                        field: 'skill'
                    }
                ]),
            ]
        },
    ];

    function formatBodyParams(data) {
        let output = {};

        for (let index in data) {
            let el = data[index]

            output[el.name] = el.value
        }

        return output;
    }

    const validated = ref(true);
    const errors = ref({
        errors: []
    });

    const apiRoute = function (currentRoute) {
        let url = currentRoute.api_url;
        let pathParams = currentRoute.pathParams
        let queryParams = currentRoute.queryParams
        let query = "";
        validated.value = true;

        for (let index in pathParams) {
            if (pathParams[index].types.includes('required') && pathParams[index].value == "") {
                validated.value = false;

                errors.value.errors = {
                    [pathParams[index].name]: ["The " + pathParams[index].name + " field is required"]
                }
            }

            url = url.replace('{' + pathParams[index].field + '}', pathParams[index].value)
        }

        for (let index in queryParams) {
            if (!queryParams[index].value)
                continue
            if (index == 0)
                query = "?"
            else
                query += "&"

            query += queryParams[index].name + "=" + queryParams[index].value
        }

        return url + query;
    };

    async function request(currentRoute) {
        let api = apiRoute(currentRoute);

        if (!validated.value) {
            return {
                response: JSON.stringify(errors.value, null, 2)
                    .replace(/"([^"]+)":/g, '<span class="text-sky-300">"$1":</span>'),
                status: 422
            }
        }

        loading.value = true;

        const body = formatBodyParams(currentRoute.bodyParams);
        const options = {
            method: currentRoute.method,
            data: body,
            url: api,
        };

        axios.defaults.headers.common['Authorization'] = "Bearer " + api_token.value;

        await axios.get('/sanctum/csrf-cookie');

        let response = "";
        let status = 0;

        await axios(options)
            .then((res) => {
                loading.value = false;
                response = res.data;
                status = res.status;

                api_token.value = response.data.access_token
            })
            .catch((error) => {
                loading.value = false;
                response = error.response.data;
                status = error.response.status;
            });

        return {
            response: JSON.stringify(response, null, 2)
                .replace(/"([^"]+)":/g, '<span class="text-sky-300">"$1":</span>'),
            status: status
        };
    }

    function bodyCodeLines(params) {
        let show = false
        let output = []

        output.push({
            code: '<span class="text-fuchsia-400">let</span> body <span class="text-sky-200">=</span> <span class="text-fuchsia-400">{</span>',
            tab: 0
        });

        for (let el in params) {

            const param = params[el]

            if (!params[el].value) continue;

            show = true;

            const stringTypes = [
                'string',
                'email',
            ];

            const numberTypes = [
                'decimal',
                'int'
            ];

            let value = "";

            if (stringTypes.some(i => param.types.includes(i)))
                value = "<span class='text-lime-300'> " + "'" + param.value + "'";
            if (numberTypes.some(i => param.types.includes(i)))
                value = "<span class='text-orange-400'> " + param.value;
            if (param.types.includes('password'))
                value = "<span class='text-lime-300'> " + "'" + param.value.replace(/[a-zA-Z0-9]/g, "*") + "'";

            output.push({
                code: param.name + "<span class='text-sky-300'>:</span> " + value + "<span class='text-sky-300'>,</span>",
                tab: 1
            });
        }

        output.push({
            code: '<span class="text-amber-300">}</span><span class="text-sky-200">;</span>',
            tab: 0
        },
            {
                code: '<span style="opacity: 0">space</span>',
                tab: 0
            });

        if (show)
            return output;

        return "";
    }

    function updateValue(param, currentRoute) {
        let el = {};

        let query = currentRoute.queryParams;
        let path = currentRoute.pathParams;
        let body = currentRoute.bodyParams;

        if (query && query.find((el) => el.name == param.name))
            el = query.find((el) => el.name == param.name);

        else if (path && path.find((el) => el.name == param.name))
            el = path.find((el) => el.name == param.name);

        else if (body && body.find((el) => el.name == param.name))
            el = body.find((el) => el.name == param.name);

        el = param
    }

    return { routes, api_token, apiRoute, loading, request, bodyCodeLines, updateValue }
})