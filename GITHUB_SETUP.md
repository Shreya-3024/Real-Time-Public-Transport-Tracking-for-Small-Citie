# 🚀 GitHub Repository Setup Guide

Complete guide for version control and collaboration using Git & GitHub.

---

## 📦 INITIAL REPOSITORY SETUP

### Step 1: Create GitHub Repository

1. Go to [github.com](https://github.com) and create a new repository:
   - Repository name: `smartcity-transport-system`
   - Description: `Real-Time Public Transport Tracking System - Laravel + React`
   - Visibility: Public (or Private for portfolio)
   - ✅ Add README file
   - ✅ Add .gitignore (Node, Laravel)
   - ✅ Choose License: MIT

### Step 2: Clone and Setup

```bash
# Clone the repository
git clone https://github.com/yourusername/smartcity-transport-system.git
cd smartcity-transport-system

# Create branch structure
git checkout -b develop
git checkout -b frontend
git checkout -b backend
git checkout main
```

---

## 📁 REPOSITORY STRUCTURE

```
smartcity-transport-system/
│
├── frontend/                 # React application
│   ├── src/
│   ├── public/
│   ├── package.json
│   ├── vite.config.ts
│   └── README.md
│
├── backend/                  # Laravel API
│   ├── app/
│   ├── database/
│   ├── routes/
│   ├── composer.json
│   └── README.md
│
├── docs/                     # Documentation
│   ├── DATABASE_SCHEMA.md
│   ├── API_DOCUMENTATION.md
│   └── DEPLOYMENT_GUIDE.md
│
├── .github/
│   └── workflows/
│       ├── frontend-ci.yml
│       └── backend-ci.yml
│
├── .gitignore
├── README.md
└── LICENSE
```

---

## 🔧 GITIGNORE CONFIGURATION

### Frontend (.gitignore)
```gitignore
# Frontend
node_modules/
dist/
build/
.env
.env.local
.env.production
*.log
.DS_Store

# IDE
.vscode/
.idea/
*.swp
*.swo
```

### Backend (.gitignore)
```gitignore
# Laravel
/vendor
/node_modules
/public/hot
/public/storage
/storage/*.key
.env
.env.backup
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log

# IDE
/.idea
/.vscode
```

---

## 📝 COMMIT MESSAGE CONVENTIONS

Use semantic commit messages:

### Format
```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code formatting (no logic change)
- `refactor`: Code restructuring
- `test`: Adding tests
- `chore`: Maintenance tasks

### Examples
```bash
git commit -m "feat(auth): add user login functionality"
git commit -m "fix(map): resolve bus marker positioning issue"
git commit -m "docs: update API documentation for trip endpoints"
git commit -m "refactor(dashboard): extract stats into separate component"
git commit -m "test(auth): add unit tests for login controller"
```

---

## 🌿 BRANCHING STRATEGY

### Branch Types

1. **main** - Production-ready code
2. **develop** - Integration branch
3. **feature/** - New features
4. **bugfix/** - Bug fixes
5. **hotfix/** - Urgent production fixes
6. **release/** - Release preparation

### Workflow

```bash
# Create feature branch from develop
git checkout develop
git pull origin develop
git checkout -b feature/real-time-tracking

# Make changes and commit
git add .
git commit -m "feat(tracking): implement GPS location updates"

# Push to remote
git push origin feature/real-time-tracking

# Create Pull Request on GitHub
# After approval, merge to develop
```

---

## 🔄 COMMON GIT WORKFLOWS

### Daily Development Workflow

```bash
# 1. Start your day - update local branches
git checkout develop
git pull origin develop

# 2. Create feature branch
git checkout -b feature/passenger-dashboard

# 3. Work on your code
# ... make changes ...

# 4. Stage and commit changes
git add src/pages/PassengerDashboard.tsx
git commit -m "feat(passenger): create dashboard layout"

# 5. Push to remote
git push origin feature/passenger-dashboard

# 6. Create Pull Request on GitHub
# 7. After review, merge to develop
```

### Updating Your Branch

```bash
# Option 1: Rebase (cleaner history)
git checkout feature/your-feature
git fetch origin
git rebase origin/develop

# Option 2: Merge
git checkout feature/your-feature
git merge develop
```

### Fixing Mistakes

```bash
# Undo last commit (keep changes)
git reset --soft HEAD~1

# Discard local changes
git checkout -- filename.tsx

# Amend last commit message
git commit --amend -m "new message"

# Stash changes temporarily
git stash
git stash pop  # retrieve later
```

---

## 🤝 PULL REQUEST TEMPLATE

Create `.github/PULL_REQUEST_TEMPLATE.md`:

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Unit tests added/updated
- [ ] Manual testing completed
- [ ] All tests passing

## Screenshots (if applicable)

## Checklist
- [ ] Code follows project style guidelines
- [ ] Self-review completed
- [ ] Comments added for complex code
- [ ] Documentation updated
- [ ] No console errors
```

---

## ⚙️ GITHUB ACTIONS CI/CD

### Frontend CI Workflow
`.github/workflows/frontend-ci.yml`:

```yaml
name: Frontend CI

on:
  push:
    branches: [ main, develop ]
    paths:
      - 'frontend/**'
  pull_request:
    branches: [ main, develop ]

jobs:
  build:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v3

    - name: Setup Node.js
      uses: actions/setup-node@v3
      with:
        node-version: '18'

    - name: Install dependencies
      working-directory: ./frontend
      run: npm ci

    - name: Run linter
      working-directory: ./frontend
      run: npm run lint

    - name: Run tests
      working-directory: ./frontend
      run: npm test

    - name: Build
      working-directory: ./frontend
      run: npm run build
```

### Backend CI Workflow
`.github/workflows/backend-ci.yml`:

```yaml
name: Backend CI

on:
  push:
    branches: [ main, develop ]
    paths:
      - 'backend/**'
  pull_request:
    branches: [ main, develop ]

jobs:
  test:
    runs-on: ubuntu-latest

    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: testing
        ports:
          - 3306:3306

    steps:
    - uses: actions/checkout@v3

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.3'
        extensions: mbstring, pdo, pdo_mysql

    - name: Install dependencies
      working-directory: ./backend
      run: composer install

    - name: Run tests
      working-directory: ./backend
      run: php artisan test
      env:
        DB_CONNECTION: mysql
        DB_HOST: 127.0.0.1
        DB_PORT: 3306
        DB_DATABASE: testing
        DB_USERNAME: root
        DB_PASSWORD: password
```

---

## 🏷️ RELEASE PROCESS

### Versioning (Semantic Versioning)

Format: `MAJOR.MINOR.PATCH`

- **MAJOR**: Breaking changes
- **MINOR**: New features (backward compatible)
- **PATCH**: Bug fixes

Example: `v1.2.3`

### Creating a Release

```bash
# 1. Update version in package.json and composer.json
# 2. Create changelog
# 3. Commit version bump
git add .
git commit -m "chore: bump version to 1.2.0"

# 4. Create tag
git tag -a v1.2.0 -m "Release version 1.2.0"

# 5. Push tag
git push origin v1.2.0

# 6. Create GitHub Release
# - Go to GitHub → Releases → Create new release
# - Select tag v1.2.0
# - Add release notes
# - Upload build artifacts (optional)
```

### CHANGELOG.md Format

```markdown
# Changelog

## [1.2.0] - 2026-05-09

### Added
- Real-time GPS tracking with WebSockets
- Emergency alert system for drivers
- Passenger nearby bus search

### Changed
- Improved map performance
- Updated UI with new color scheme

### Fixed
- Login redirect issue
- Map marker clustering bug

### Security
- Updated dependencies
- Fixed XSS vulnerability in search
```

---

## 👥 COLLABORATION WORKFLOW

### For Team Members

#### 1. Fork & Clone
```bash
# Fork repository on GitHub
# Clone your fork
git clone https://github.com/yourusername/smartcity-transport-system.git
cd smartcity-transport-system

# Add upstream remote
git remote add upstream https://github.com/original-owner/smartcity-transport-system.git
```

#### 2. Keep Fork Updated
```bash
git fetch upstream
git checkout develop
git merge upstream/develop
git push origin develop
```

#### 3. Create Feature Branch
```bash
git checkout -b feature/add-notifications
# Make changes
git push origin feature/add-notifications
```

#### 4. Create Pull Request
- Go to your fork on GitHub
- Click "Compare & pull request"
- Fill in PR template
- Request reviewers
- Wait for approval

### Code Review Guidelines

**For Reviewers:**
- Check code quality and style
- Verify functionality
- Test edge cases
- Provide constructive feedback
- Approve or request changes

**For Authors:**
- Respond to feedback
- Make requested changes
- Re-request review
- Squash commits if needed

---

## 📊 PROJECT MANAGEMENT

### GitHub Issues

Create issue templates:

#### Bug Report Template
```markdown
**Describe the bug**
A clear description

**To Reproduce**
Steps to reproduce:
1. Go to '...'
2. Click on '...'
3. See error

**Expected behavior**

**Screenshots**

**Environment:**
- OS: [e.g. macOS]
- Browser: [e.g. Chrome]
- Version: [e.g. 22]
```

#### Feature Request Template
```markdown
**Is your feature request related to a problem?**

**Describe the solution**

**Describe alternatives considered**

**Additional context**
```

### GitHub Projects

Create project board:
1. Go to Projects → New project
2. Choose "Board" template
3. Columns:
   - 📋 Backlog
   - 🔜 To Do
   - 🏗️ In Progress
   - 👀 In Review
   - ✅ Done

---

## 🔒 SECURITY BEST PRACTICES

### Protecting Sensitive Data

```bash
# Never commit:
.env files
API keys
Database passwords
SSH keys
Access tokens
```

### Using GitHub Secrets

1. Go to Settings → Secrets and variables → Actions
2. Add secrets:
   - `DB_PASSWORD`
   - `API_KEY`
   - `JWT_SECRET`

3. Use in workflows:
```yaml
env:
  DB_PASSWORD: ${{ secrets.DB_PASSWORD }}
```

### Security Scanning

Enable:
- Dependabot alerts
- Code scanning
- Secret scanning

---

## 📈 REPOSITORY INSIGHTS

### Track Metrics
- Code frequency
- Commit activity
- Contributors
- Traffic (views, clones)
- Popular content

### Use Labels
Create labels for issues/PRs:
- `bug` 🐛
- `feature` ✨
- `documentation` 📝
- `help wanted` 🆘
- `good first issue` 👶
- `priority: high` 🔥
- `priority: low` 🔽

---

## 🎯 QUICK REFERENCE

### Essential Commands

```bash
# Clone
git clone <url>

# Status
git status

# Add files
git add .
git add filename

# Commit
git commit -m "message"

# Push
git push origin branch-name

# Pull
git pull origin branch-name

# Create branch
git checkout -b branch-name

# Switch branch
git checkout branch-name

# Merge
git merge branch-name

# View history
git log --oneline
git log --graph

# Diff
git diff
git diff filename

# Stash
git stash
git stash pop
git stash list

# Tags
git tag
git tag -a v1.0.0 -m "message"
git push origin v1.0.0
```

---

## 🌟 PORTFOLIO TIPS

### README Badges

Add to your README.md:

```markdown
![GitHub stars](https://img.shields.io/github/stars/username/repo)
![GitHub forks](https://img.shields.io/github/forks/username/repo)
![GitHub issues](https://img.shields.io/github/issues/username/repo)
![GitHub license](https://img.shields.io/github/license/username/repo)
![Build Status](https://img.shields.io/github/workflow/status/username/repo/CI)
```

### Project Stats

Highlight in README:
- Lines of code
- Number of commits
- Contributors
- Technologies used
- Live demo link
- Screenshots/GIFs

### Documentation

Ensure you have:
- ✅ Clear README
- ✅ API documentation
- ✅ Setup instructions
- ✅ Architecture diagrams
- ✅ Database schema
- ✅ Deployment guide

---

## 🎓 LEARNING RESOURCES

- [Git Documentation](https://git-scm.com/doc)
- [GitHub Guides](https://guides.github.com)
- [Atlassian Git Tutorials](https://www.atlassian.com/git/tutorials)
- [Oh My Git! (Game)](https://ohmygit.org)

---

**Your repository is now professional, organized, and ready for collaboration!** 🚀
