import js from '@eslint/js';
import globals from 'globals';

export default [
  js.configs.recommended,
  {
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'module',
      globals: {
        ...globals.browser,
        ...globals.node,
      },
    },
    rules: {
      // ANCHOR: Code Quality Rules
      'no-unused-vars': ['error', { argsIgnorePattern: '^_' }],
      'no-console': 'warn',
      'no-debugger': 'error',
      'no-alert': 'error',
      
      // ANCHOR: Best Practices
      'prefer-const': 'error',
      'no-var': 'error',
      'no-duplicate-imports': 'error',
      'no-unreachable': 'error',
      
      // ANCHOR: Readability
      'indent': ['error', 2],
      'quotes': ['error', 'single'],
      'semi': ['error', 'always'],
      'comma-dangle': ['error', 'always-multiline'],
      'object-curly-spacing': ['error', 'always'],
      'array-bracket-spacing': ['error', 'never'],
      
      // ANCHOR: Function Naming Convention
      'func-names': ['error', 'always'],
      'prefer-arrow-callback': 'error',
      
      // ANCHOR: Early Returns
      'no-else-return': 'error',
      'no-nested-ternary': 'error',
      
      // ANCHOR: Performance
      'no-loop-func': 'error',
      'no-new-func': 'error',
    },
  },
  {
    files: ['resources/js/**/*.js', 'resources/js/**/*.ts', 'resources/js/**/*.jsx', 'resources/js/**/*.tsx'],
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'module',
      globals: {
        ...globals.browser,
      },
    },
  },
  {
    files: ['vite.config.js', '*.config.js'],
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'module',
      globals: {
        ...globals.node,
      },
    },
  },
  {
    ignores: [
      'node_modules/**',
      'vendor/**',
      'storage/**',
      'bootstrap/cache/**',
      'public/build/**',
      '*.min.js',
      '*.bundle.js',
    ],
  },
]; 