using Microsoft.AspNetCore.Mvc;

namespace RevenueManagement.Controllers
{
    public class UserController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }

        [HttpGet]
        public IActionResult? Create()
        {
            return View();
        }

        [HttpGet]
        public IActionResult? Edit()
        {
            return null;
        }

        [HttpPatch]
        public IActionResult? Update()
        {
            return null;
        }

        [HttpDelete]
        public IActionResult? Delete()
        {
            return null;
        }

        [HttpPatch]
        public IActionResult? ChangePassword()
        {
            return null;
        }
    }
}
