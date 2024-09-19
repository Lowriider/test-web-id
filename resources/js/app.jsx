import {render} from "react-dom";
import {createInertiaApp} from "@inertiajs/inertia-react";
import {InertiaProgress} from '@inertiajs/progress'
import '../css/app.css';
import React from 'react';

InertiaProgress.init({
    color: "#542DE0"
});

function resolvePageComponent(name, pages) {
    for (const path in pages) {
        if (path.endsWith(`${name.replace('.', '/')}.jsx`)) {
            return typeof pages[path] === 'function'
                ? pages[path]()
                : pages[path]
        }
    }

    throw new Error(`Page not found: ${name}`)
}

createInertiaApp({
    title: title => `Quartz - ${title}`,
    resolve: (name) => resolvePageComponent(name, import.meta.glob('./Pages/**/*.jsx'),`../Pages/${name}`),
    setup({el, App, props}) {
        render(<App {...props} />, el);
    },
});