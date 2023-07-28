
import { usePage } from '@inertiajs/vue3';


// ------ getImageUrl -------

export const getImageUrl = (path) =>  {


    path = path.replace(/^\/?/, '')

    return new URL(`/resources/${path}`, import.meta.url).href;
}


// ------ can -------

export const can = (permission) => {

    const DBPermissions = usePage().props.value.permissions;

    for(let DBPermission of DBPermissions) {

        if(DBPermission.name == permission) {
            return true;
        }
    }

    return false
}


// ------ __ -------

export const __ = (key, params = {}) => {

    const translations = usePage().props.value.translations;

    let translation = translations[key] ?? key;

    Object.keys(params).forEach(paramName => {

        translation = translation.replace(':' + paramName, params[paramName]);
    });

    return translation;
}
