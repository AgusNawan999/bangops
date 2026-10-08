import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue');
    return pages[`./Pages/${name}.vue`]();
  },
  setup({ el, App, props, plugin }) {
    const vueApp = createApp({ render: () => h(App, props) });

    // Custom Directive: v-role="'admin'"
    vueApp.directive('role', (el, binding) => {
      const roles = props.initialPage.props.auth_user?.roles || [];
      const requiredRole = binding.value;
      
      const hasAccess = Array.isArray(requiredRole)
        ? requiredRole.some(r => roles.includes(r))
        : roles.includes(requiredRole);

      if (!hasAccess) {
        el.style.display = 'none';
      }
    });

    // Custom Directive: v-permission="'execute operations'"
    vueApp.directive('permission', (el, binding) => {
      const permissions = props.initialPage.props.auth_user?.permissions || [];
      const requiredPermission = binding.value;

      const hasAccess = Array.isArray(requiredPermission)
        ? requiredPermission.some(p => permissions.includes(p))
        : permissions.includes(requiredPermission);

      if (!hasAccess) {
        el.style.display = 'none';
      }
    });

    vueApp.use(plugin).mount(el);
  },
});