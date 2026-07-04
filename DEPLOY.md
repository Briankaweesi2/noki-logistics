# Deploying the Noki Logistics theme

This theme auto-deploys to **https://nokilogistics.com** on every push to `main`.
No zip uploads, no FTP, no SSH.

## The pipeline
```
edit theme  →  git commit (bump version)  →  Push in GitHub Desktop
                                                     │
                                          GitHub Actions (.github/workflows/deploy.yml)
                                                     │
                              curl → Deployer for Git push-to-deploy URL
                                                     │
                        WordPress pulls the latest zip from GitHub and installs it
```

- **Repo:** https://github.com/Briankaweesi2/noki-logistics (public)
- **Branch deployed:** `main`
- **Plugin on the site:** *Deployer for Git* (configured to track `main`)
- **Workflow:** `.github/workflows/deploy.yml`

## To ship a change
1. Edit theme files.
2. **Bump the version** in `style.css` (`Version:` header) and the two `wp_enqueue_*` version strings in `functions.php`. Deployer installs on every push regardless, but bumping keeps the reported version accurate and busts browser cache.
3. `git commit`.
4. **GitHub Desktop → Push origin.**
5. Watch **GitHub → Actions → "Deploy to WordPress"**. Green ✓ = deployed.

## The secret
GitHub → repo → Settings → Secrets and variables → Actions:
- **Name:** `DFG_THEME_DEPLOY_URL`
- **Value:** the push-to-deploy URL from **wp-admin → Deployer for Git → Dashboard**
  (`https://nokilogistics.com/wp-json/dfg/v1/package_update?secret=…&type=theme&package=noki-logistics`)

If the secret ever changes/regenerates in Deployer for Git, update this GitHub secret to match.

## Verify a deploy
- **GitHub → Actions** → the run's "Trigger Deployer for Git" step should log `HTTP status: 200`.
- **wp-admin → Appearance → Themes → Noki Logistics** shows the new version.
- **wp-admin → Deployer for Git → Logs** shows the pull.

## Rollback
- **GitHub Desktop → History** → right-click the last good commit → **Revert changes** → Push. The revert deploys automatically.
- Or in the repo, reset `main` to a previous commit and push.

## Notes
- `.gitignore` excludes `_stock-backup/`, `*.zip`, `.DS_Store`, `node_modules/`.
- First-time bootstrap (already done) required one manual File Manager upload so the installed theme carried the `GitHub Theme URI` header.
- After deploy, if a caching plugin is active and a change isn't visible, purge the cache.
