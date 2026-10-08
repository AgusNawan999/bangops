import { usePage } from '@inertiajs/vue3';

export function useAuth() {
  const page = usePage();

  // Ambil data auth_user dari props Inertia
  const user = () => page.props.auth_user || {};

  // Cek apakah user memiliki role tertentu
  const hasRole = (roleName) => {
    const roles = user().roles || [];
    if (Array.isArray(roleName)) {
      return roleName.some(r => roles.includes(r));
    }
    return roles.includes(roleName);
  };

  // Cek apakah user memiliki permission tertentu
  const hasPermission = (permissionName) => {
    const permissions = user().permissions || [];
    if (Array.isArray(permissionName)) {
      return permissionName.some(p => permissions.includes(p));
    }
    return permissions.includes(permissionName);
  };

  return {
    user,
    hasRole,
    hasPermission,
  };
}
